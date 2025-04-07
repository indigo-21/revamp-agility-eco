<?php

namespace App\Services;

use App\Models\User;
use Hash;

class UserService
{
    public function store($request)
    {

        $user = new User();

        $profile_image = (new StoreImage)->store($request, 'photo', 'profile_images');

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->organisation = $request->organisation;
        $user->photo = $profile_image;
        $user->mobile = $request->mobile;
        $user->landline = $request->landline;
        $user->account_level_id = $request->account_level_id;
        $user->user_type_id = $request->user_type_id;
        $user->password = Hash::make('password');

        $user->save();

        return $user;
    }
}