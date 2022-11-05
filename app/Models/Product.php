<?php

namespace App\Models;

use App\Libs\ImageURL;
use Illuminate\Support\Str;
use App\Traits\ProductTrait;
use App\Traits\FullTextSearch;
use App\Traits\ProductWithOptionTrait;
use App\Traits\StatusTrait;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Type;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    public $timestamps = false;
    const KEY = 'products';

    public function price_format($strike = false){
        $price = $strike ? $this->priceStrike : $this->price;
        return $price > 0 ? number_format($price) . ' ' . $this->unit : '';
    }


    public static function getProduct(){
        $data = self::where('status', '>', 1)->whereIn('type_product', [1, 2])->get()->keyBy('type_product');
        return $data;
    }
}

