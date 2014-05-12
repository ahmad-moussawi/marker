<?php

class AuthController extends \BaseController {

    public function postLogin() {

        if (Auth::attempt(array(
                    'login' => Input::get('login'),
                    'password' => Input::get('password'),
                ))) {

            return Response::json(array(
                        'status' => true,
                        'member' => Auth::user()->toArray()
            ));
        } else {
            return Response::json(array(
                        'status' => false,
                        'member' => null
            ));
        }
    }

    public function postLogout() {
        Auth::logout();
        return Response::json(true);
    }
    
    public function getHash($str){
        return Hash::make($str);
    }
    
    public function postCheck() {
        if (Auth::check()) {
            return Response::json(array('status' => true, 'member' => Auth::user()->toArray()));
        } else {
            return Response::json(array('status' => false, 'member' => null));
        }
    }

    public function postChangepwd() {
        if (Auth::check()) {
            $old = Input::get('old');
            $password = Input::get('password');
            $confirm = Input::get('confirm');

            if ($confirm !== $password) {
                return Response::json('Password must match Confirm Password', 500);
            }

            if (!Auth::validate(array(
                        'login' => Auth::user()->login,
                        'password' => $old
                    ))) {
                return Response::json('The old password is incorrect', 500);
            }

            Auth::user()->password = Hash::make($password);
            Auth::user()->save();

            return Response::json(true);
        } else {
            return Response::json('NotAuthorized', 401);
        }
    }

}
