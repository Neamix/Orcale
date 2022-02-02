<?php

namespace App\Models;

use App\Json;
use App\Mail\forget;
use App\messageCenter;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Declare rule for a single request
     * 
     * @var array
     */
    private $declareRules = [];

    /**
     * Get the rule of each col
     * 
     * @return array
     */

    protected $with = [
        'track',
        'love',
        'seenAll',
        'watchLater',
        'watched',
        'wantToSee',
    ];

    static function createInstance($request) {
        $user = User::create([
            'name' => $request->name,
            'password'=> Hash::make($request->password),
            'email'   => $request->email
        ]);

        if(!Auth::attempt($request->only('email','password'),true))
        {
            return Json::result(false,['register' => 'Failed to register']);
        } else {
            return Json::result(true,User::find($user->id));
        }
    }

    static function sign($user)
    {
        if(!Auth::attempt($user->only('email','password'),true)) {
            return Json::result(false,['register' => 'Failed to register']);
        } else {
            return Json::result(true,Auth::user());
        }
    }

    public function forgetPassword($token)
    {
        $forgetData = [
            'email' => $this->email,
            'token' => mt_rand(1000000000000000, 9999999999999999),
            'created_at' => NOW()
        ];
        
        $forget = DB::table('password_resets')->insert($forgetData);
        dd($this->email);
        Mail::to($this->email)
            ->queue(new forget($forgetData));
        
        return Json::result('success','"Boom, We have send reset email to you"');
    }

    /**
     * Check if token exist
     * 
     * @param token string
     * @param email string|email
     * 
     * @return json
     */

    static function validResetToken(string $token,string $email)
    {
        $token = DB::table('password_resets')->where(['token' => $token,'email' => $email])->select()->get()->toArray();
        if(!empty($token))
        {
            if(strtotime($token[0]->created_at." +4 hours") > strtotime(Carbon::now())) 
            {
                return Json::result(true,$token);                
            } else {
                return Json::result(false,'This token is expired');

            }
        } else {
            return Json::result(false,'token valid');
        }
    }

    /**
     * Reset token
     * @param token => reset token
     * @param email => user email
     * @param password => new password
     */

    static function reset(string $token,string $email,$password)
    {
        $token = DB::table('password_resets')->where(['token' => $token,'email' => $email])->select('email')->get()->toArray();

        if(!empty($token)) {
           $user = User::where('email',$email)->update([
               'password' => Hash::make($password)
           ]);

           DB::table('password_resets')->where(['email' => $email])->delete();

           return Json::result(true);
           
        } else {
            return Json::result(false,['unexpected error occure']);
        }
    }

    /**
     * Register by social media
     */

    static function socialite($user)
    {        
        $user = User::firstOrCreate([
            'email' => $user->email
        ],[
            'name' => $user->getName() ?? $user->getNickname(),
            'email' => $user->getEmail(),
            'password' => Hash::make(rand(1,10000))
        ]);

        Auth::loginUsingId($user->id);


        return Json::result(true);
    }

    /**
     * Change User information 
     * @param col => col that will change 
     * @param val => new value 
     * @return Json
     */

    public function modify($col,$val)
    {
        if($col !== 'password') {
            $this->$col = $val;
        } else {
            $this->$col = Hash::make($val);
        }   
        $this->save();
        return Json::result(true,"$col has been changed successfully");  
    }

    /**
     * Get User info
     * @return RegisterUser
     */

    public static function auth()
    {
        return User::with('track.shows','seenAll.shows','watchLater.shows','love.shows','wantToSee.shows','watched.shows')->find(Auth::id())->toArray();
    }

    //Relations 

    public function track()
    {
        return $this->hasMany(action::class)->where('action_type','tr');
    }

    public function seenAll()
    {
        return $this->hasMany(action::class)->where('action_type','sn');
    }

    public function watchLater()
    {
        return $this->hasMany(action::class)->where('action_type','wl');
    }

    public function watched()
    {
        return $this->hasMany(action::class)->where('action_type','wd');
    }

    public function wantToSee()
    {
        return $this->hasMany(action::class)->where('action_type','wts');
    }

    public function love()
    {
        return $this->hasMany(action::class)->where('action_type','lv');
    }
}

