<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Hashids\Hashids;

use App\User;

class UsersController extends Controller {

    public function __construct() {

        $this->middleware('jsonwebtokenadmin');

    }

    private function decode_id($id) {

        $hashids = new Hashids('Gaano', 10);

        return $hashids->decode($id);

    }

    public function all() {

        $users = User::where(function($que) {

            $que->where('status', 1);
            $que->orWhere('status', 0);

        })->with('profile', 'identification', 'has_reservation')->orderBy('created_at', 'desc')->get();

        return response()->json($users, 200);

    }

    public function read($id) {

        $decode_id = $this->decode_id($id);

        $user = User::whereId($decode_id)->with('profile', 'identification', 'has_reservation')->first();

        return response()->json($user, 200);

    }

    public function update_status(Request $request) {

        $decode_id = $this->decode_id($request->userid);

        $user = User::whereId($decode_id)->first();
        $user->status = $request->status;
        $user->save();

        return response()->json($user, 200);

    }

}
