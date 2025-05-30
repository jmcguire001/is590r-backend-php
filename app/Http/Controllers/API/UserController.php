<?php

namespace App\Http\Controllers\API;

use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UserController extends BaseController
{
    public function getUser() {
        $authUser = Auth::user();
        $user = User::findOrFail($authUser->id);
        $user->avatar = $this->getS3Url($user->avatar);
        return $this->sendResponse($user, 'User');
    }

    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        if ($request->hasFile('image')) {
            $authUser = Auth::user();
            $user = User::findOrFail($authUser->id);
            $extension  = request()->file('image')->getClientOriginalExtension(); //This is to get the extension of the image file just uploaded
            $image_name = time() .'_' . $authUser->id . '.' . $extension;
            $path = $request->file('image')->storeAs(
                'images',
                $image_name,
                's3'
            );
            Storage::disk('s3')->setVisibility($path, "public");
            if(!$path) {
                return $this->sendError($path, 'User profile avatar failed to upload!');
            }

            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('s3')->delete($user->avatar);
            }
            
            $user->avatar = $path;
            $user->save();
            $success['avatar'] = null;
            if(isset($user->avatar)){
                $success['avatar'] = $this->getS3Url($path);
            }
            return $this->sendResponse($success, 'User profile avatar uploaded successfully!');
        }
    }

    public function removeAvatar()
    {
        // Get authenticated user
        $authUser = Auth::user();
    
        // Force the authUser to be an instance of the User model
        $user = \App\Models\User::findOrFail($authUser->id);
    
        // Check if user has an avatar
        if (!$user->avatar) {
            return response()->json(['message' => 'No avatar to remove'], 404);
        }
    
        // Delete avatar from S3 storage
        Storage::disk('s3')->delete($user->avatar);
    
        // Set avatar field to null and save
        $user->avatar = null;
        $user->save();
    
        // Return success response
        return response()->json([
            'avatar' => null,
            'message' => 'User profile avatar removed successfully!'
        ], 200);
    }    
}