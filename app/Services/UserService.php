<?php

namespace App\Services;

use App\Models\User;
use Hash;

class UserService
{
    public function store($request, $user_id = null)
    {
       
        if ($user_id) {
            $user = User::find($user_id);
        } else {
            $user = new User();
            $user->password = Hash::make('password');
            $user->user_type_id = $request->user_type_id;
        }

        if($request instanceof \Illuminate\Http\Request){
            $profile_image = (new StoreImage)->store($request, 'photo', 'profile_images');

            if ($profile_image) {
                $user->photo = $profile_image;
            }
        }

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->organisation = $request->organisation;
        $user->mobile = $request->mobile;
        $user->landline = $request->landline;
        $user->account_level_id = $request->account_level_id;

        $user->save();

        return $user;
    }
}