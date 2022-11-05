<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    public $timestamps = false;


    public static function getFeedback($limit){
        $data = self::where('status', '>', 1)->orderByRaw('sort ASC')->limit($limit)->get();
        return $data;
    }
}