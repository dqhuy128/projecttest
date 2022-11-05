<?php

/**
 * Created by PhpStorm.
 * Filename: SearchingService.php
 * User: Thang Nguyen Nhan
 * Date: 4/28/20
 * Time: 00:57
 */

namespace App\Services;

use App\Libs\Lib;
use App\Models\ExecutiveBoard;
use App\Models\News;
use App\Models\Page;
use App\Models\Product;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class SearchingService {
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function search($keyword = '') {
        if(!empty($keyword)) {

            $arr_key = explode(' ', $keyword);
            $only_integers = array_filter($arr_key,'ctype_digit');
            $only_string = array_diff_key($arr_key, array_flip((array) array_keys($only_integers)));

            $product = Product::getProductsByKey(implode(' ', $only_string), $only_integers)->paginate(7);
            $data = [
                'data' => [],
                'total' => 0
            ];

            if($product->total() > 0) {
                $data['total'] = $product->total();
                foreach($product as $item) {
                    $temp = [
                        'title' => $item->title,
                        'img' => \ImageURL::getImageUrl($item->image, 'products', 'small'),
                        'url' => route('product.detail', ['alias' => $item->alias]),
                        'price' => $item->price > 0 ? 'Giá từ: '.\Lib::priceFormat($item->price, 'đ') : 'Miễn phí',
                        'combo' => $item->product_combo_count
                    ];
                    $data['data'][] = $temp;
                }
            }

            return Lib::ajaxRespondV2(true, 'Success', $data);
        }
        return Lib::ajaxRespondV2(false, 'Fail', [],Response::HTTP_BAD_REQUEST);
    }


}