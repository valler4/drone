<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Traits\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    use logs;

    public function edit(Request $request)
    {
        $user = $request->user();

        return view('edits.edit-profile', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');

            $imagename = $user->id.'.'.$file->getClientOriginalExtension();

            if ($user->profile_image && Storage::disk('public')->exists('profile_images/'.$user->profile_image)) {
                Storage::disk('public')->delete('profile_images/'.$user->profile_image);
            }

            $file->storeAs('profile_images', $imagename, 'public');

            $data['profile_image'] = $imagename;
        }

        $this->logActivity('update profile', 'profile updated successfully', "id: {$user->id} user {$user->user_name} updated his profile");

        $user->fill($data)->save();

        return redirect()->route('profile')->with('success', 'Profile updated');
    }
}
