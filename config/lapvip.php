<?php 
return [
    'host' => env('LAPVIP_HOST', 'lapvip.vn'),
    'filter_cates' => [
        'category' => 'Danh mục',
        'price_range' => 'Khoảng giá',
        'demand' => 'Nhu cầu sử dụng',
    ],
    'special_offers' => [
        'price' => 'Giảm số tiền cụ thể trực tiếp vào giá bán',
        'voucher_accessory' => 'Tặng phiếu mua hàng phụ kiện',
        'refund' => 'Hoàn tiền'
    ],
    'special_offers_status' => [
        'available' => 1
    ],
    'flash_sale' => [
        'status' => [
            'available' => 2
        ]
    ],
];