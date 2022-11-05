<?php

return [
    'backend' => [
        'product'       => ['controller'=>'Product','title' => 'Sản phẩm'],
        'customer'      => ['controller'=>'Customer','title' => 'Khách hàng nói gì về chúng tôi'],
        'recipe'        => ['controller'=>'Recipe','title' => 'Công thức'],
        'choose'        => ['controller'=>'Choose','title' => 'Lựa chọn'],
        'intro'        => ['controller'=>'Intro','title' => 'Giới thiệu'],
        'feature'       => ['controller'=>'Feature','title' => 'Banner'],
        'contact'       => ['controller'=>'Contact', 'title' => 'Liên Hệ', 'form' => 1,'perm'=>['view' => 'Xem', 'edit' => 'Sửa', 'delete' => 'Xóa']],
        'user'          => ['controller'=>'User','title' => 'Người dùng'],
        'role'          => ['controller'=>'Role','title' => 'Phân quyền'],
        'menu'          => ['controller'=>'Menu','title' => 'Menu'],
        'config'        => ['controller'=>'Config','title' => 'Cấu hình website','form' => 1,'perm'=>['change' => 'Thay đổi cấu hình']],
        'config_home'   => ['controller'=>'ConfigHome','title' => 'Cấu hình Trang Chủ','form' => 1,'perm'=>['change' => 'Thay đổi cấu hình trang chủ']],
    ] // End back end
];
