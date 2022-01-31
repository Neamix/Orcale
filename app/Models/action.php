<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class action extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','show_identifier','show_type','action_type'];
    
    static function add($show,$action)
    {
        if(Auth::check())
        {
           $check = action::where(['user_id'=> Auth::id(),'show_identifier' => $show['id'],'show_type'=>$show['type'],'action_type' => $action])->get()->toArray();
           if(empty($check))
           {
                action::create([
                    'user_id' => Auth::id(),
                    'show_identifier' => $show['id'],
                    'show_type' => $show['type'],
                    'action_type' => $action
                ]);
           } else {
                action::where([
                    'user_id' => Auth::id(),
                    'show_identifier' => $show['id'],
                    'show_type' => $show['type'],
                    'action_type' => $action
                ])->delete();
           }
       
        } else {
            dd('no auth');
        }
    }

    //Relations 
    public function shows()
    {
        return $this->belongsTo(show::class,'show_identifier','identifier');
    }
}
