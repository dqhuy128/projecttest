<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intro extends Model
{
    protected $table = 'intro';
    public $timestamps = false;


    public static function getIntroHome(){
        $wery = self::where('status','>',1)->orderByRaw('sort ASC')->get();
        return $wery;
    }
}