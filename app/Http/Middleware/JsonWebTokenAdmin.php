<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class JsonWebTokenAdmin {

    public function handle($request, Closure $next) {

        $JWT_parse = JWTAuth::parseToken()->authenticate();

        $status = Auth::Guard('api')->user()->status;

        if($JWT_parse && $status === 2) {

            return $next($request);

        } elseif($JWT_parse && $status === 1) {

            return redirect('/home');

        } else {

            return redirect('/');

        }


    }

}
