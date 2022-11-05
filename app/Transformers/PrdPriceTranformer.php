<?php
/**
 * Created by PhpStorm.
 * Filename: PrdPriceTranformer.php
 * User: Thang Nguyen Nhan
 * Date: 20-Jul-19
 * Time: 04:15
 */

namespace App\Transformers;

use App\Libs\Lib;
use App\Models\ProductPrices;
use League\Fractal;

class PrdPriceTranformer extends Fractal\TransformerAbstract
{
    public function transform($prd)
    {
        if (!empty($prd)){
            $param_filter = ['param_filter_title' => '', 'param_filter_value' => ''];
            
            if (isset($prd->image)){
                if(is_array ($prd->image)) {
                    $image_filter = $prd->image;
                }else {
                    $image_filter = json_decode($prd->image);
                }
            }
            if (isset($prd->param)){
                if(is_array ($prd->param)) {
                    $param_filter = $prd->param;
                }else {
                    $param_filter = !empty($prd->param) ? json_decode($prd->param) : ['param_filter_title' => '', 'param_filter_value' => ''];
                }
            }
            if (isset($prd->parameter)){
                if(is_array ($prd->parameter)) {
                    $param_filter = $prd->parameter;
                }else {
                    $param_filter = !empty($prd->parameter) ? json_decode($prd->parameter) : ['param_filter_title' => '', 'param_filter_value' => ''];
                }
            }


            $data = [
                'key_price'      => isset($prd->filter_ids) ? $prd->filter_ids : '',
                'combo_price'      => isset($prd->combo_ids) ? $prd->combo_ids : '',
                'price'          => Lib::priceFormat($prd->price,false),
                'price_strike'          => Lib::priceFormat($prd->price_strike,false),
                'image_filter'   => @$image_filter,
                'param_filter'   => $param_filter,
//            'quantity'      => $prd->quantity
                'storage' => isset($prd->storage) ? $prd->storage : '',
            ];
            if (isset($prd->filters)){
                foreach($prd->filters as $item) {
                    $data['obj'][] = [
                        'id' => $item['id'],
                        'title' => $item['title'],
                    ];
                }
            }
            if (isset($prd->combo)){
                foreach ($prd->combo as $item_combo){
                    $data['obj_combo'][] = [
                        'id' => $item_combo['id'],
                        'title_combo' => $item_combo['title'],
                    ];
                }
            }
        }


        return isset($data) ? $data : [];
    }
}