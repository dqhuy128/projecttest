<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Choose extends Model
{
    protected $table = 'choose';
    public $timestamps = false;


    public static function getChoose(){
        $wery = self::where('status','>',1)->limit(2)->orderByRaw('sort ASC')->get();
        return $wery;
    }
}