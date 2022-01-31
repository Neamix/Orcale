<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Json;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Laravel\Socialite\Facades\Socialite;


class UserController extends Controller
{

    public function sign(Request $request)
    {
        return User::sign($request);
    }

    /**
     *  Regsiter a new user
     * 
     *  @return json
     */

    public function register(UserRequest $request)
    {
        return User::createInstance($request);
    }

    /**
     *  Send Forget Mail
     * 
     * @param Request $request
     */
    public function forget(Request $request)
    {
        $user = User::where('email',$request->email)->first();

        if($user->count()) {
            return $user->forgetPassword('asdasd');
        } else {
            return Json::result(false,'We can\'t find this email in our database');
        }
    }
    
    /**
     * Check if the token is valid
     * 
     * @param token string
     * @param email string|email
     */

    public function validToken(Request $request)
    {
        return User::validResetToken($request->token,$request->email);
    }


    /**
     * Reset Password
     * 
     * @return json
     */

    public function resetPassword(ResetPasswordRequest $request)
    {
        $password = User::reset($request->token,$request->email,$request->password);
        return $password;
    }

    public function Auth()
    {
        if(Auth::check()) {
            return Json::result(true,User::auth());
        } else return Json::result(false);
    }

    public function socialite($drive) 
    {
        return Socialite::driver($drive)->redirect();
    }

    public function resocialite($drive)
    {
        $user = Socialite::driver($drive)->user();
        $user = User::socialite($user);
        return \redirect()->route('vue',['any'=>'/']);
    }

    public function user()
    {
        if(Auth::check())
        {
            return false;
        } else return Json::result(false);
    }

    public function modify(UserUpdateRequest $request)
    {

        foreach($request->all() as $key => $value)
        {
            return Auth::user()->modify($key,$value);
        }

        return $validated;
    }

    public function changePassword(UserUpdateRequest $request)
    {
        if(Auth::check()) {
            if(\password_verify($request->password_old,Auth::user()->password)) {
                return Auth::user()->modify('password',$request->password);
            } else {
                return Json::result(false,['The password you entried not correct']);
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('vue',['any'=>'discover']);
    }

    public function delete()
    {
        $user = User::find(Auth::id());
        $user->delete();
        return redirect()->route('vue',['any'=>'discover']);
    }

}