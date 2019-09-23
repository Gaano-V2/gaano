<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Mail;

use App\Profile;
use App\User;
use App\Identification;

class ProfileController extends Controller {

    public function __construct() {

        $this->middleware('jsonwebtokenuser');

    }

    private function guard() {

        return Auth::Guard('api');

    }

    private function return_value($key) {

        return response()->json([
            'access_token' => $key,
            'profile' => User::whereId($this->guard()->user()->id)->first(),
            'user' => $this->guard()->user()->profile,
            'identification' => $this->guard()->user()->identification
        ], 200);

    }

    public function update_avatar(Request $request) {

        request()->validate([
              'avatar' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg'],
        ]);

        $file_data = $request->file('avatar');

        $file_name = Storage::disk('public')->put('avatars', $file_data);

        $profile = Profile::where('user_id', $this->guard()->user()->id)->first();
        $current_avatar = $profile->avatar;
        $profile->avatar = $file_name;
        $profile->save();

        if($profile->save()) {

            if($profile->avatar != null) {

                Storage::disk('public')->delete($current_avatar);

            }

        }

        return $this->return_value($request->key);

    }

    public function update_profile(Request $request) {


        $profile = Profile::where('user_id', $this->guard()->user()->id)->first();

        $profile->fname = $request->fname;
        $profile->mname = $request->mname;
        $profile->lname = $request->lname;
        $profile->gender = $request->gender;
        $profile->bday = $request->bday;
        if($profile->phone !== $request->phone) {
            $request->validate([
                'phone' => ['required', 'string', 'max:12', 'unique:profiles'],
            ]);
            $profile->phone = $request->phone;
        }
        $profile->save();

        return $this->return_value($request->key);

    }

    public function update_email(Request $request) {

        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        $email = $request->email;

        $user = User::whereid($this->guard()->user()->id)->first();
        $user->email = $email;
        $user->save();

        if ($user->save() == true) {

            Mail::send('emails.send', ['title' => "Test", 'content' => "Test"], function($message) use($email){
                $message->subject('Email Change');
                $message->from('laravelandmail@gmail.com', 'Gaano');
                $message->to($email);
            });

        }

        return $this->return_value($request->key);

    }

    public function update_password(Request $request) {

        $user = User::whereid($this->guard()->user()->id)->first();

        $request->validate([
            'password' => ['required', 'string', 'dumbpwd', 'min:8', 'confirmed'],
            'current_password' => ['required', function ($attribute, $value, $fail) use($user) {
                if (!\Hash::check($value, $user->password)) {
                    return $fail(__('The current password is incorrect.'));
                }
            }],
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        if ($user->save() == true) {

            $email = $user->email;

            Mail::send('emails.send', ['title' => "Test", 'content' => "Test"], function($message) use($email){
                $message->subject('Password Change');
                $message->from('laravelandmail@gmail.com', 'Gaano');
                $message->to($email);
            });

        }

        return $this->return_value($request->key);

    }

    public function identification(Request $request) {

        $user = User::whereId($this->guard()->user()->id)->with('identification')->first();

        if($user->identification == null) {

            $new_credential = new Identification();
            $new_credential->user_id = $user->id;

            if($request->hasFile('government_id')) {
                request()->validate([
                      'government_id' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg'],
                ]);

                $file_data = $request->file('government_id');

                $file_name = Storage::disk('public')->put('government', $file_data);

                $new_credential->government_id = $file_name;
            }

            if($request->hasFile('license')) {
                request()->validate([
                      'license' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg'],
                ]);

                $file_data = $request->file('license');

                $file_name = Storage::disk('public')->put('license', $file_data);

                $new_credential->license = $file_name;
            }

            $new_credential->save();


        }

        if($user->identification != null) {

            $credential = Identification::where('user_id', $user->id)->first();
            $g_id = $credential->government_id;
            $l_id = $credential->license;

            if($request->hasFile('government_id')) {
                request()->validate([
                      'government_id' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg'],
                ]);

                $file_data = $request->file('government_id');

                $file_name = Storage::disk('public')->put('government', $file_data);

                $credential->government_id = $file_name;
            }

            if($request->hasFile('license')) {
                request()->validate([
                      'license' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg'],
                ]);

                $file_data = $request->file('license');

                $file_name = Storage::disk('public')->put('license', $file_data);

                $credential->license = $file_name;

            }

            $credential->save();

            if($credential->save()) {

                if($request->hasFile('government_id')) {

                    Storage::disk('public')->delete($g_id);

                }

                if($request->hasFile('license')) {

                    Storage::disk('public')->delete($l_id);

                }

            }

        }

        return $this->return_value($request->key);

    }

}
