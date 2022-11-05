@extends('FrontEnd::layouts.home')

@section('title') {!! \Lib::siteTitle($def['site_title']) !!} @stop

@section('content')
    <div id="js-margin-top">
        <main>
            <section class="page--thanku banner">
                <div class="content--page">
                    <div class="text-center">
                        <span class="desc text-uppercase mt-5 mb-3" style="color: #D30008; font-size: 30px;">
                            CẢM ƠN BẠN ĐÃ ĐỂ LẠI THÔNG TIN
                        </span>
                        <span class="desc">
                            Chúng tôi sẽ liên hệ đến bạn trong thời gian sớm nhất !
                        </span>
                    </div>
                </div>
            </section>
        </main>
    </div>

@endsection