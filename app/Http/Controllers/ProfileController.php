<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\FriendRequest;
use App\Traits\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use logs;

    public function edit(Request $request)
    {
        $user = $request->user();

        return view('profile.edit', compact('user'));
    }

    public function show(User $user)
    {

        $friendRequest = FriendRequest::where('sender_id', Auth::id())
            ->where('receiver_id', $user->id)
            ->where('status', 'pending')
            ->first();

        return view('profile.show', compact('user', 'friendRequest'));
    }

    public function sendFriendRequest(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id|different:sender_id',
        ], [
            'different' => 'You cannot send a friend request to yourself!'
        ]);

        FriendRequest::updateOrCreate(
            [
                'sender_id' => Auth::id(),
                'receiver_id' => $request->receiver_id
            ],
            [
                'status' => 'pending'
            ]
        );

        // $friendRequest->receiver->notify(new FriendRequestNotification($friendRequest));

        return redirect()->back()->with('success', 'Friend request sent successfully!');
    }

    public function deleteFriendRequest(FriendRequest $friendRequest)
    {

        if ($friendRequest->sender_id === (int) Auth::id()) {
            $friendRequest->delete();
        }

        return redirect()->back()->with('success', 'Request canceled.');
    }

    public function update(ProfileRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');

            $imagename = $user->id . '.' . $file->extension();

            if ($user->profile_image && Storage::disk('public')->exists('profile_images/' . $user->profile_image)) {
                Storage::disk('public')->delete('profile_images/' . $user->profile_image);
            }

            $file->storeAs('profile_images', $imagename, 'public');

            $data['profile_image'] = $imagename;
        }

        $user->fill($data)->save();

        return redirect()->route('settings')->with('success', 'Profile updated');
    }
}
