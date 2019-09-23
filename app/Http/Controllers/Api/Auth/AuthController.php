<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Mail;

use App\User;
use App\Profile;


class AuthController extends Controller {

    private $passport;
    private $failsafe;

    public function __construct() {

        $this->middleware('jsonwebtokenuser', ['except' => ['login', 'register']]);

    }

    private function respondWithToken() {

        $credentials = ['email' => $this->passport['email'],
                        'password' => $this->passport['password']];

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Incorrect Password or Email Address'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'user' => $this->guard()->user()->profile,
            'profile' => User::whereId($this->guard()->user()->id)->first(),
            'identification' => $this->guard()->user()->identification
        ]);

    }

    private function guard() {

        return Auth::Guard('api');

    }

    public function register(Request $request) {

        $request->validate([
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users'],
            'password' => ['required', 'string', 'dumbpwd', 'min:8', 'confirmed'],
            'fname' => ['required', 'string', 'max:150'],
            'mname' => ['max:150'],
            'lname' => ['required', 'string', 'max:150'],
            'gender' => ['required', 'max:2'],
            'bday' => ['required', 'string', 'before:-18 years', 'max:15'],
            'phone' => ['required', 'string', 'max:12', 'unique:profiles'],
        ]);

        $email = $request->email;

        $new_user = new User();
        $new_user->email = $email;
        $new_user->password = Hash::make($request->password);
        $new_user->save();

        $this->failsafe = $new_user->id;

        $new_profile = new Profile();
        $new_profile->user_id = $new_user->id;
        $new_profile->fname = $request->fname;
        $new_profile->mname = $request->mname;
        $new_profile->lname = $request->lname;
        $new_profile->gender = $request->gender;
        $new_profile->bday = $request->bday;
        $new_profile->phone = $request->phone;
        $new_profile->save();

        if ($new_profile->save() == true) {

            Mail::send('emails.send', ['title' => "Test", 'content' => "Test"], function($message) use($email){
                $message->subject('Welcome To EM');
                $message->from('laravelandmail@gmail.com', 'Mason Pines');
                $message->to($email);
            });

        }

        if ($new_profile->save() == false) {

            $fail_user = User::whereId($this->failsafe)->first();
            $fail_user->delete();

            return response()->json(['Message' => "Something Went Wrong!"], 500);

        }

        $this->passport = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        return $this->respondWithToken();

    }

    public function login(Request $request) {

        $this->passport = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        return $this->respondWithToken();

    }

    public function logout() {

        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);

    }

}
