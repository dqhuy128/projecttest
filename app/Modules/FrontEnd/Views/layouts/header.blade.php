
<header class="header header-scroll-sticky">
    <div class="header-row">
        <div class="logo">
            <a href="{{route('home')}}" title="">
                <img src="{{asset('template/images/logo-red.png')}}" alt="trang chủ" />
            </a>
        </div>

        <div class="menu">
            <div class="menu-hamburger">
                <div class="menu-hamburger-line"></div>
                <div class="menu-hamburger-line"></div>
                <div class="menu-hamburger-line"></div>
            </div>
            <div class="menu-overlay"></div>
            <div class="menu-items">
                <div class="menu-links">
                    <div class="menu-parent active">
                        <a href="{{route('home')}}" title="">Trang chủ</a>
                    </div>
                </div>
                @if(!empty($menu))
                    @php
                        usort($menu, function ($a, $b){
                                return $a['sort'] > $b['sort'];
                            });
                    @endphp
                    @foreach($menu as $item)
                        <div class="menu-links">
                            <div class="menu-parent">
                                <a href="javascript:;" class="js-scrollId" data-section="section-{{$item['sort']}}" title="">{{$item['title']}}</a>
                            </div>
                        </div>
                    @endforeach
                @endif
{{--                <div class="menu-links">--}}
{{--                    <div class="menu-parent">--}}
{{--                        <a href="javascript:;" class="js-scrollId" data-section="section-2" title="">nguy cơ thiếu canxi</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="menu-links">--}}
{{--                    <div class="menu-parent">--}}
{{--                        <a href="javascript:;" class="js-scrollId" data-section="section-4" title="">công dụng</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="menu-links">--}}
{{--                    <div class="menu-parent">--}}
{{--                        <a href="javascript:;" class="js-scrollId" data-section="section-5" title="">cách dùng</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="menu-links menu-links-button">
                    <div class="menu-parent">
                        <a href="javascript:;" class="js-scrollId" data-section="section-7" title="">Ưu đãi hấp dẫn</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="hotline">
{{--            <a href="tel:{{$def['hotline']}}" > Tư vấn ngay --}}{{--: {{$def['hotline']}}--}}{{-- </a>--}}
            <a href="javascript:;" class="js-scrollId" data-section="form-block"> Tư vấn ngay {{-- : {{$def['hotline']}}--}} </a>
        </div>
    </div>
</header>