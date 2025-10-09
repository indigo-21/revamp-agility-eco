<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Mail;

class UserService
{
    public function store($request, $user_id = null)
    {

        $randomPassword = Str::random(10);

        if ($user_id) {
            $user = User::find($user_id);
        } else {
            $user = new User();
            $user->fill(['password' => $randomPassword]);
            $user->user_type_id = $request->user_type_id;
            $user->account_level_id = $request->account_level_id;
        }

        $profile_image = (new StoreImage)->store($request, 'photo', 'profile_images');

        if ($profile_image) {
            $user->photo = $profile_image;
        }

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->organisation = $request->organisation;
        $user->mobile = $request->mobile;
        $user->landline = $request->landline;

        $user->save();

        if (!$user_id) {
            $appName = env('APP_NAME');
            $appUrl = env('APP_URL');
            // $email = 'james.zarsuelo@indigo21.com';
            $subject = "Welcome to $appName – Your Account Details";

            $token = Password::createToken($user);
            $resetUrl = "{$appUrl}/reset-password/{$token}?email=" . urlencode($user->email);

            $data = [
                '_APP_NAME_' => $appName,
                '_NAME_' => $request->firstname,
                '_EMAIL_' => $request->email,
                '_TEMP_PASSWORD_' => $randomPassword,
                '_PASSWORD_LINK_' => $resetUrl,
            ];

            $template = '
                <h2>Welcome to _APP_NAME_, _NAME_!</h2>

                <p>Your account has been successfully created and you will need to login within the next 24 hours. Below is your temporary password:</p>

                <ul>
                    <li><strong>Username (Email):</strong> _EMAIL_</li>
                    <li><strong>Temporary Password:</strong> 
                        <span style="background: #f4f4f4; padding: 6px 10px; border-radius: 4px; display: inline-block; font-size: 16px;">
                            _TEMP_PASSWORD_
                        </span>
                    </li>
                </ul>

                <p style="color: #e63946;"><strong>For your security, please change this password immediately after logging in.</strong></p>

                <p>You can update your password by clicking the button below:</p>

                <a href="_PASSWORD_LINK_" style="
                    background-color: #1d72b8;
                    color: #ffffff;
                    padding: 12px 24px;
                    text-decoration: none;
                    border-radius: 6px;
                    font-weight: bold;
                    display: inline-block;
                    margin: 16px 0;
                ">Change Your Password</a>

                <p>If the button doesn`t work, copy and paste this link into your browser:</p>
                <p><a href="_PASSWORD_LINK_">_PASSWORD_LINK_</a></p>

                <p>If you have left this for more than 24 hours, please use the <strong>Username (Email)</strong> above and click on "Forgot your password" button to create a new password. If you have any questions or need help accessing your account, feel free to contact our support team.</p>

                <p>Best regards,<br>
                _APP_NAME_ AMI Support Team</p>
            ';

            (new MailService)->sendEmail($subject, $template, $request->email, $data);
        }

        return $user;
    }
}