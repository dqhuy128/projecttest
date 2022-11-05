@extends('FrontEnd::layouts.home')
@section('title') {!! \Lib::siteTitle($def['site_title']) !!} @stop
@section ('content')
  <main>
    <div class="container">
      <div class="block-content-404">
        <img class="logo-site-404" src="{{asset('html-viettech/images/logo-404.png')}}" alt="">
        <img class="image-404" src="{{asset('html-viettech/images/404.png')}}" alt="">
        <h1 class="title-404">Rất tiếc, trang bạn tìm kiếm không tồn tại</h1>
        <form action="" class="form-404">
          <input type="text" name="q" id="search_404" placeholder="Bạn muốn tìm gì?">
          <button class="btn-submit" onclick="shop.search('search_404')">
            <svg width="25" height="23" viewBox="0 0 25 23" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M17.602 16.3224C20.3713 12.8464 19.7984 7.78362 16.3224 5.0143C12.8465 2.24497 7.78363 2.81783 5.01431 6.29382C2.24498 9.7698 2.81784 14.8326 6.29383 17.602C9.76981 20.3713 14.8326 19.7984 17.602 16.3224ZM15.3806 14.5525C17.1725 12.3034 16.8018 9.02743 14.5526 7.23551C12.3035 5.4436 9.02753 5.81427 7.23562 8.06344C5.4437 10.3126 5.81438 13.5886 8.06354 15.3805C10.3127 17.1724 13.5887 16.8017 15.3806 14.5525Z"
                    fill="white" />
              <rect x="14.8652" y="15.9583" width="2.36679" height="10.4139" rx="1.18339"
                    transform="rotate(-51.4556 14.8652 15.9583)" fill="white" />
            </svg>
          </button>
        </form>
        <p class="call-link">
          Gọi ngay <a href="tel:{{$def['hotline']}}" title="">{{$def['hotline']}}</a> ( miễn phí cuộc gọi) để được hỗ trợ
        </p>
        <span class="single-text-other">Hoặc</span>
        <a href="{{route('home')}}" class="back-to-home">Quay về trang chủ</a>
      </div>

    </div>
  </main>
@stop

