<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserService
{
    // Register
    public function registerUser(array $params) {
        $user = User::create(array_merge(
            $params,
            ['password' => bcrypt(data_get($params, 'password'))]
        ));

        return $user;
    }

    // Login
    public function login(array $credentials) {
        $token = auth()->attempt($credentials);

        return $token;
    }

    // Update Profile Name
    public function updateProfileName(array $params) {
        
        $user = auth()->user();
        $updated = $user->update([
            'name' => data_get($params, 'name'),
        ]);
        
        return $updated ? true : false;
    }

    // Update Profile Password
    public function updateProfilePassword(array $params) {
        
        $user = auth()->user();
        $updated = $user->update([
            'password' => bcrypt(data_get($params, 'password'))
        ]);

        return $updated ? true : false;
    }

    // Update Profile Avatar Picture
    public function updateProfileAvatar(UploadedFile $file) {
        $user = auth()->user();
        $user_id = $user->id;
        $user_name = $user->name;
        $file_path = "user/{$user_id}_{$user_name}/avatar";

        $extension = strtolower($file->getClientOriginalExtension());
        $filename = "avatar.{$extension}";

        $path = $file->storeAs($file_path, $filename, 's3');
        $url = Storage::url($path);

        $user->update([
            'avatar_pic' => $url
        ]);

        return $url;
    }
}