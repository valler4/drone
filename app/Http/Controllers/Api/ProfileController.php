<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FriendRequest;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function edit(Request $request)
    {
        return UserResource::collection(User::where('id', '=', Auth::id())->get());
    }

    public function show(Request $request, User $user)
    {
        $friendRequest = FriendRequest::where('sender_id', Auth::id())
            ->where('receiver_id', $user->id)
            ->where('status', 'pending')
            ->first();

        $user->friendship_info = $friendRequest ? $friendRequest->status : null;

        return new UserResource($user);
    }

    public function sendFriendRequest(Request $request, User $user)
    {

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found!'
            ], 404);
        }

        if ($user->id === Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot send a friend request to yourself!'
            ], 400);
        }

        FriendRequest::updateOrCreate(
            [
                'sender_id' => Auth::id(),
                'receiver_id' => $user->id
            ],
            [
                'status' => 'pending'
            ]
        );
        return response()->json([
            'success' => true,
            'message' => 'Friend request sent successfully!'
        ]);
    }

    public function deleteFriendRequest(Request $request, User $user)
    {
        $friendRequest = FriendRequest::where('sender_id', Auth::id())
            ->where('receiver_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($friendRequest) {
            $friendRequest->delete();
            return response()->json([
                'success' => true,
                'message' => 'Request canceled.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Unauthorized action.'
        ], 403);
    }


    public function update(ProfileRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');

            $imageName = $user->id . '.' . $file->extension();

            if ($user->profile_image && Storage::disk('public')->exists('profile_images/' . $user->profile_image)) {
                Storage::disk('public')->delete('profile_images/' . $user->profile_image);
            }

            $file->storeAs('profile_images', $imageName, 'public');

            $data['profile_image'] = $imageName;
        }

        $user->fill($data)->save();

        return new UserResource($user);
    }
}
