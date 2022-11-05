@extends('FrontEnd::layouts.home')

@section('title') {!! \Lib::siteTitle($def['site_title']) !!} @stop

@section('content')
    <div id="js-margin-top">
        <main>
            @if(!empty($slide))
                <section class="banner">
                    <div class="image">
                        <img src="{{\ImageURL::getImageUrl($slide->image, 'feature', '1920x762')}}"
                             alt="{{$slide->title.' '.$slide->title_sub}}">
                    </div>
                    <div class="text">
                        <div class="text-center wow fadeInUp">
                            @if(!empty($slide->title))
                                <h2 class="title">
                                    {{$slide->title}}
                                </h2>
                            @endif
                            @if(!empty($slide->title_sub))
                                <h2 class="title second">
                                    {{$slide->title_sub}}
                                </h2>
                            @endif
                            @if(!empty($slide->des))
                                <span class="desc">
                                    {{strip_tags($slide->des)}}
                                </span>
                            @endif

                            <div class="d-block">
                                @isset($def['shopee'])
                                    <a href="{{!empty($def['shopee']) ? $def['shopee'] : 'javascript:;'}}"
                                        target="_blank" class="btn-view mx-xl-5 mx-lg-2">
                                        Xem thêm tại
                                        <img src="{{asset('template/images/shoppe-ic.png')}}" alt="">
                                    </a>
                                @endif
                                @isset($def['lazada'])
                                    <a href="{{!empty($def['lazada']) ? $def['lazada'] : 'javascript:;'}}" target="_blank" class="btn-view mx-xl-5 mx-lg-2 mx-3">
                                        Xem thêm tại
                                        <img src="{{asset('template/images/lazada-ic.png')}}" alt="">
                                    </a>
                                @endif
                            </div>

                        </div>
                    </div>
                </section>
            @endif

            @if(!empty($intro))
                <section class="section-1">
                    <div class="container">
                        @foreach($intro as $itm)
                            <div class="block-section-path">
                                <div class="row align-items-center">
                                    <div class="col-md-6 col-12">
                                        <div class="image wow fadeInLeft">
                                            <img src="{{ImageURL::getImageUrl($itm->image, 'intro', '600x392')}}"
                                                 alt="{{$itm->title}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="text wow fadeInRight">
                                            <h2 class="title">
                                                {{$itm->title}}
                                            </h2>
                                            <span class="desc">
                                              {{$itm->description}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <section class="section-2">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 mb-4 mb-lg-0 col-12">
                            <div class="image wow fadeInLeft">
                                <img src="{{@$config_home['570x570']}}" alt="{{@$config_home['title_sec3']}}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="intro-desc wow fadeInRight">
                                <h2 class="title">
                                    {{@$config_home['title_sec3']}}
                                </h2>
                                <p class="sub" style="font-size: 18px">
                                    {!! preg_replace("/\r\n/", '<br/>', @$config_home['des_sec3']) !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-3" {{--style="background: url({{asset('template/images/bg-canxi.png')}});"--}}>
                <div class="container">
                    <div class="head-title-component wow fadeInUp">
                        <h2 class="title text-dark off-text-shadow">
                            {{@$config_home['title_sec4']}}
                        </h2>
{{--                        <h3 class="sub-title text-dark">--}}
{{--                            thông qua bữa ăn gia đình?--}}
{{--                        </h3>--}}
                    </div>

                    <!-- large img screen >= 576 -->
                    <!--d-none d-sm-block-->

                    <div class="image-main-large d-none d-sm-block  wow fadeInDown text-center">
                        <img src="{{@$config_home['1170x916']}}" alt="{{@$config_home['title_sec4']}}">
{{--                        <img src="{{asset('template/images/KewpieLP-CaVoTrung-Section4.png')}}" alt="">--}}
                    </div>

                    <!-- content screen < 576 -->
                    <div class="image-main d-block d-sm-none my-4 my-sm-0 wow fadeInDown text-center">
                        <img src="{{@$config_home['original']}}" alt="{{@$config_home['title_sec4']}}">
{{--                        <img src="{{asset('template/images/KewpieLP-CaVoTrung-Section4 (1) 1.png')}}" alt="">--}}
                    </div>
{{--                    @if(!empty($config_home['des_sec4']))--}}
{{--                        @php($xxx = explode('#', $config_home['des_sec4']))--}}
{{--                        <ul class="list-option d-flex flex-wrap d-sm-none wow fadeInDown">--}}
{{--                            @foreach($xxx as $im)--}}
{{--                                <li>{{$im}}</li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    @endif--}}

                </div>
            </section>

            <!-- content -->
            <section class="section-4">
                <div class="container">
                    <div class="head-title-component wow fadeInUp">
                        <h2 class="title text-white">
                            {{@$config_home['title_top_sec5']}}
                        </h2>
                        <h3 class="sub-title text-red">
                            {{@$config_home['title_bot_sec5']}}
                        </h3>
                    </div>

                    <!-- content -->

                    <!-- <div class="section-4-content">
                      <div class="row align-items-center">
                        <div class="col-lg-6 col-12  wow fadeInLeft">
                          <ul class="list-options">
                            <li>
                              <h2 class="title">
                                Tăng khả năng hấp thu CANXI
                              </h2>
                              <span class="desc">
                                Hấp thu dễ dàng nhờ sử dụng CANXI từ vỏ trứng <br />
                                Cơ thể có thể hấp thu CANXI từ xốt tới 35%, cao hơn CANXI trong sữa và cao hơn gấp 2 lần CANXI
                                cacbonat dưới dạng thuốc
                              </span>
                            </li>
                            <li>
                              <h2 class="title">
                                Dễ sử dụng
                              </h2>
                              <span class="desc">
                                Thêm trực tiếp vào gạo, không cần giảm lượng nước <br />
                                Khuấy đều xốt và nấu cơm như bình thường với nồi cơm điện hoặc các loại nồi cơm khác
                              </span>
                            </li>
                            <li>
                              <h2 class="title">
                                Chi phí hợp lý
                              </h2>
                              <span class="desc">
                                Bữa ăn dinh dưỡng cho cả gia đình <br />
                                Chi phí mỗi ngày chỉ từ 6.000 VNĐ/ 1 gia đình (4 thành viên)
                              </span>
                            </li>
                          </ul>
                        </div>
                        <div class="col-lg-6 col-12 d-none d-lg-block  wow fadeInRight">
                          <div class="image">
                            <img src="images/img-egg.png" alt="">
                          </div>
                        </div>
                      </div>
                    </div> -->

                    <div class="section-4-content section-4-col2">
                        <div class="container">
                            <div class="row">
                                @if(!empty($choose))
                                    @foreach($choose as $itm)
                                        <div class="col-lg-6 col-12 mb-4 mb-lg-0">
                                            <div class="box-content">
                                                <div class="image">
                                                    <img src="{{\ImageURL::getImageUrl($itm->image, 'choose', '555x460')}}" alt="{{$itm->title}}">
                                                </div>

                                                <div class="content">
                                                    <h2 class="title">
                                                        {!! preg_replace("/#/", '<br/>', $itm->title) !!}
                                                    </h2>

                                                    <div class="sub">
                                                        {{$itm->content}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <section class="section-5">
                <div class="container">

                    <div class="head-title-component wow fadeInUp">
                        <h2 class="title text-dark off-text-shadow">
                            {{@$config_home['title_top_sec6']}}
                        </h2>
                        <h3 class="sub-title text-red">
                            {{@$config_home['title_bot_sec6']}}
                        </h3>
                    </div>
                    @if(!empty($recipe))
                        <div class="sync-slide wow fadeInDown">

                            <div class="primary-slide">
                                <!-- Swiper -->
                                <div class="swiper mySwiper">
                                    <div class="swiper-wrapper">
                                        @foreach($recipe as $itm_img)
                                            <div class="swiper-slide">
                                                <img src="{{\ImageURL::getImageUrl($itm_img->image, 'recipe', '1170x982')}}"
                                                     alt="{{$itm_img->title}}">
                                            </div>
                                        @endforeach

                                    </div>
                                </div>

                                <div class="primary-navigation">
                                    <div class="swiper-button-next">
                                        <img src="{{asset('template/images/arrow-right-red.png')}}" alt="">
                                    </div>
                                    <div class="swiper-button-prev">
                                        <img src="{{asset('template/images/arrow-left-red.png')}}" alt="">
                                    </div>
                                </div>
                            </div>

                            <div class="sub-slide">
                                <!-- Swiper -->
                                <div class="swiper mySwiper">
                                    <div class="swiper-wrapper">
                                        @foreach($recipe as $itm)
                                            <div class="swiper-slide">
                                                <div class="step">
                                                    <div class="step-count">
                                                        {{$itm->title}}
                                                    </div>
                                                    <div class="step-desc">
                                                        {{$itm->description}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </section>

            <section class="section-6">
                <div class="container">
                    <div class="head-title-component wow fadeInUp">
                        <h2 class="title text-dark off-text-shadow">
                            {{@$config_home['title_top_sec7']}}
                        </h2>
                        <h3 class="sub-title text-dark">
                            {{@$config_home['title_bot_sec7']}}
                        </h3>
                    </div>
                    @if(!empty($customer_talk))
                        <div class="client-said wow fadeInDown">
                            <div class="client-said-js">
                                <div class="swiper mySwiper">
                                    <div class="swiper-wrapper">
                                        @foreach($customer_talk as $itm)
                                            <div class="swiper-slide">
                                                <div class="client-item">
                                                    <div class="image">
                                                        <img src="{{\ImageURL::getImageUrl($itm->image, 'customer', '370x353')}}"
                                                             alt="{{$itm->name}}">
                                                    </div>
                                                    <div class="content">
                                                        <div class="desc">
                                                            {!! $itm->feedback !!}
                                                        </div>
                                                        <div class="person">
                                                            <h2 class="title">
                                                                {{$itm->name}}
                                                            </h2>
                                                            <span class="sub">
                                                              {{$itm->address}}
                                                            </span>
                                                            <img src="{{\ImageURL::getImageUrl($itm->avartar, 'customer', '84x84')}}"
                                                                 alt="{{$itm->name}}" class="ava">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- navi -->
                                <div class="swiper-button-prev">
                                    <img src="{{asset('template/images/nav-circle-left.png')}}" alt="">
                                </div>
                                <div class="swiper-button-next">
                                    <img src="{{asset('template/images/nav-circle-right.png')}}" alt="">
                                </div>
                                <!-- pagi -->
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    @endif
                </div>
            </section>

            <div class="section-7" style="background: url({{asset('template/images/bg-section7.png')}});">
                <div class="container">
                    <div class="head-title-component wow fadeInUp">
                        <h2 class="title text-white off-text-shadow">
                            {{@$config_home['title_top_sec8']}}
                        </h2>
                    </div>
                    <!-- content -->
                    <div class="product-block">
                        <div class="row">
                            @if(isset($product[1]))
                                <div class="col-md-6 col-12 mb-4 mb-md-0 wow fadeInLeft">
                                    <div class="product-item">
                                        <div class="product-img">
                                            <img src="{{\ImageURL::getImageUrl($product[1]->image, 'products', '346x415')}}"
                                                 alt="{{$product[1]->title.' Gói đơn 100 ml'}}">
                                        </div>
                                        <div class="product-child">
                                            <div class="product-margin">
                                                <h2 class="title">
                                                    {{$product[1]->title}}
                                                </h2>
                                                <span class="price">
                                                  Gói đơn 100 ml {{--: <span class="price-count">{{\Lib::priceFormat($product[1]->price, 'VND')}}</span>--}}
                                                </span>
                                                <div class="ecommerce">
                                                    <a href="{{!empty($product[1]->link_shopee) ? $product[1]->link_shopee : 'javascript:;'}}"
                                                       @if(!empty($product[1]->link_shopee)) target="_blank"
                                                       @endif class="ecommerce-item shopee">
                                                        Mua trên Shopee
                                                        <img src="{{asset('template/images/shoppe-ic.png')}}" alt="">
                                                    </a>
                                                    <a href="{{!empty($product[1]->link_lazada) ? $product[1]->link_lazada : 'javascript:;'}}"
                                                       @if(!empty($product[1]->link_lazada)) target="_blank"
                                                       @endif class="ecommerce-item lazada">
                                                        Mua trên Lazada
                                                        <img src="{{asset('template/images/lazada-ic.png')}}" alt="">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(isset($product[2]))
                                <div class="col-md-6 col-12 wow fadeInRight">
                                    <div class="product-item">
                                        <div class="product-img">
                                            <img src="{{\ImageURL::getImageUrl($product[2]->image, 'products', '381x422')}}"
                                                 alt="{{$product[2]->title.' Gói đơn 100 ml'}}">
                                        </div>
                                        <div class="product-child">
                                            <div class="product-margin">
                                                <h2 class="title">
                                                    {{$product[2]->title}}
                                                </h2>
                                                <span class="price">
                                                      Combo 3 gói {{--: <span class="price-count">{{\Lib::priceFormat($product[2]->price, 'VND')}}</span>--}}
                                                    </span>
                                                <div class="ecommerce">
                                                    <a href="{{!empty($product[2]->link_shopee) ? $product[2]->link_shopee : 'javascript:;'}}"
                                                       @if(!empty($product[2]->link_shopee)) target="_blank"
                                                       @endif class="ecommerce-item shopee">
                                                        Mua trên Shopee
                                                        <img src="{{asset('template/images/shoppe-ic.png')}}" alt="">
                                                    </a>
                                                    <a href="{{!empty($product[2]->link_lazada) ? $product[2]->link_lazada : 'javascript:;'}}"
                                                       @if(!empty($product[2]->link_shopee)) target="_blank"
                                                       @endif class="ecommerce-item lazada">
                                                        Mua trên Lazada
                                                        <img src="{{asset('template/images/lazada-ic.png')}}" alt="">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- form -->
                    <div class="form-block  wow fadeInUp">

                        <div class="form-top-title">
                            <h2 class="title">
                                Bạn cần tư vấn về sản phẩm?
                            </h2>

                            <span class="sub">
                                  Để lại thông tin và Kewpie sẽ hỗ trợ giải đáp mọi thắc mắc của bạn
                                </span>
                        </div>

                        <style>
                            .section-7 .form-input textarea {
                                display: block;
                                font-weight: normal;
                                font-size: 13px;
                                line-height: 15px;
                                color: #4f4f4f;
                                background: #e8e8e8;
                                border-radius: 8px;
                                border: unset;
                                width: 100%;
                                padding: 17px;
                            }
                        </style>

                        {!! Form::open(['url' => '', 'files' => true,'id' => 'contact-form', 'class' => 'form-flex']) !!}
                        <div class="form-input-block">
                            <div class="form-input">
                                <input type="text" name="contact_name" id="contact_name" class="{{$errors->has('contact_name') ? 'is-invalid' : 'reverse'}}" value="{{old('contact_name')}}" placeholder="Họ và tên">
                                <small id="contact_name_contact_page" class="invalid-feedback text-danger">{{ $errors->has('contact_name') ? $errors->first('contact_name') : '' }}</small>
                            </div>
                            <div class="form-input">
                                <input type="text" name="contact_phone" id="contact_phone" class="{{$errors->has('contact_phone') ? 'is-invalid' : 'reverse'}}" value="{{old('contact_phone')}}" placeholder="Số điện thoại" onkeypress="return numberOnly()">
                                <small id="contact_phone_contact_page" class="invalid-feedback text-danger">{{ $errors->has('contact_phone') ? $errors->first('contact_phone') : '' }}</small>
                            </div>
                        </div>
                        <div class="form-input-block m-0 w-100 mb-3">
                            <div class="form-input w-100" style="flex: 1; padding: 0; max-width: 100%">
                                <textarea name="contact_support" id="contact_support" class="mt-3 mt-md-0 {{$errors->has('contact_support') ? 'is-invalid' : 'reverse'}}" value="{{old('contact_support')}}" placeholder="Nội dung cần tư vấn" cols="30" rows="5"></textarea>
{{--                                <input type="text" name="contact_support" id="contact_support" >--}}
                                <small id="contact_support_contact_page" class="invalid-feedback text-danger">{{ $errors->has('contact_support') ? $errors->first('contact_support') : '' }}</small>
                            </div>
                        </div>

                        {{--<!-- <div class="form-radio-block">
                            <div class="form-radio-item">
                                <div class="form-radio">
                                    <input type="radio" name="contact_product" id="banle" value="Sản phẩm lẻ">
                                    <label for="banle">
                                        Sản phẩm lẻ
                                    </label>
                                </div>

                                <div class="form-radio">
                                    <input type="radio" name="contact_product" id="combo" value="Combo 3 gói">
                                    <label for="combo">
                                        Combo 3 gói
                                    </label>
                                </div>
                            </div>
                            <small id="contact_product_contact_page"
                                   class="invalid-feedback text-danger">{{ $errors->has('contact_product') ? $errors->first('contact_product') : '' }}</small>

                        </div> -->--}}

                        <div class="form-submit mt-3 mt-md-0">
                                <button class="submit">Gửi ngay</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

        </main>
    </div>
@endsection
@section('js_bot')
    <script>
        function numberOnly(myfield, e) {
            var key, keychar;
            if (window.event) {
                key = window.event.keyCode
            } else if (e) {
                key = e.which
            } else {
                return true
            }
            keychar = String.fromCharCode(key);
            if ((key == null) || (key == 0) || (key == 8) || (key == 9) || (key == 13) || (key == 27)) {
                return true
            } else if ((".0123456789").indexOf(keychar) > -1) {
                return true
            }
            return false
        };
        $(document).ready(function () {
            $('#contact-form').on('submit', function (e) {
                var data = $(this).serialize();
                $('#contact-form input').removeClass('is-invalid').addClass('reverse');
                $.ajax({
                    type: 'POST',
                    url: "{{ route('contact.post') }}",
                    data: data,
                    dataType: 'json',
                    statusCode: {
                        422: function (response) {
                            var json = JSON.parse(response.responseText);
                            if (json) {
                                $('#contact-form small.invalid-feedback').empty();
                                $.each(json.errors, function (key, val) {
                                    $('#' + key).removeClass('reverse').addClass('is-invalid');
                                    $('#contact-form small#' + key + '_contact_page').html(val[0]).css('display', 'block')
                                });
                            }
                        }
                    },
                    beforeSend: function () {

                    }
                }).done(function (json) {
                    // Swal.fire({
                    //     type: 'success',
                    //     title: 'Thông Báo',
                    //     text: 'Cảm ơn bạn! Thông tin của bạn đã được ghi nhận thành công! Kewpie sẽ sớm trả lời bạn.',
                    // });
                    $('#contact-form input[type="text"]').val('');
                    $('#contact-form input[type="radio"]').prop('checked', false);
                    $('#contact-form small.invalid-feedback').empty();
                    window.location.href = json.data.url;

                }).always(function () {
                    $('#contact-form').find('button.btn').attr("disabled", false);
                    // hide_loader();
                });

                return false;
            })
        });
        $(window).bind('load', function () {
            // sync slide - section-5

            var syncSub = new Swiper(".sub-slide .mySwiper", {
                allowTouchMove: false,
                watchSlidesVisibility: true,
                watchSlidesProgress: true,
                autoHeight: true,
            });

            var syncPrimary = new Swiper(".primary-slide .mySwiper", {
                spaceBetween: 10,
                thumbs: {
                    swiper: syncSub
                },
                navigation: {
                    nextEl: ".primary-slide .swiper-button-next",
                    prevEl: ".primary-slide .swiper-button-prev",
                },
            });

            // khách hàng nói gì về chúng tôi - section-6
            var clientSlide = new Swiper(".client-said-js .mySwiper", {
                autoplay: true,
                breakpoints: {
                    320: {
                        slidesPerView: 1,
                        spaceBetween: 10
                    },
                    576: {
                        slidesPerView: 2,
                        spaceBetween: 15
                    },
                    992: {
                        slidesPerView: 3,
                        spaceBetween: 15
                    },
                    1200: {
                        slidesPerView: 3,
                        spaceBetween: 30
                    },
                },
                navigation: {
                    prevEl: ".client-said-js .swiper-button-prev",
                    nextEl: ".client-said-js .swiper-button-next",
                },
                pagination: {
                    el: ".client-said-js .swiper-pagination",
                    clickable: true
                },
            });
        });
    </script>
@endsection