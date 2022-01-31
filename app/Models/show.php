<?php

namespace App\Models;

use App\Respatory\showRepo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class show extends Model
{
    use HasFactory;

    

    /**==================== Action on Show ================= */
    static function action($show,$action)
    {
        $check = DB::table('shows')->where(['identifier' => $show['id'],'type' => $show['type']])->select('id')->get()->toArray();
        if(empty($check)) {
            DB::table('shows')->insert([
                'identifier' => $show['id'],
                'name' => $show['name'],
                'type' => $show['type'],
                'image' => $show['poster_path']
            ]);
        }
        action::add($show,$action);
    }

}
