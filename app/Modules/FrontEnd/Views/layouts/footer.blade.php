<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-sm-6">
                <div class="introduce-corp">
                    <!-- logo -->
                    <div class="logo">
                        <a href="{{route('home')}}">
                            <img src="{{asset('template/images/logo-red.png')}}" alt="trang chủ" />
                        </a>
                    </div>

                    <!-- description -->
                    <div class="description">
                        Cơm thêm Canxi, <br />
                        xương thêm chắc khoẻ
                    </div>

                    <!-- copyright -->
                    <div class="copyright">ⓒ Copyright @ Kewpie Vietnam. All rights reserved</div>
                </div>
            </div>
            <div class="col-lg-4 col-12 mt-4 mt-lg-0 order-sm-3 order-lg-0">
                <div class="contact-corp">
                    <!-- title -->
                    <h3 class="title title-footer-small">Trụ sở</h3>

                    <!-- contact -->
                    <ul class="contact-list">
                        <li>
                            <img src="{{asset('template/images/map.png')}}" alt="map" />
                            {{$def['address_wh']}}
                        </li>
                    </ul>

                    <!-- share -->
                    <div class="social-share">
                        <a href="{{$def['facebook']}}" target="_blank">
                            <img src="{{asset('template/images/fb.png')}}" alt="facebook" />
                        </a>
                        <a href="{{$def['youtube']}}" target="_blank">
                            <img src="{{asset('template/images/ytb.png')}}" alt="youtube" />
                        </a>
                        <a href="{{$def['facebook_message']}}" target="_blank">
                            <img src="{{asset('template/images/mess.png')}}" alt="message" />
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 mt-4 mt-sm-0 order-sm-2 order-lg-0">
                <div class="advise-corp">
                    <!-- title -->
                    <h3 class="title title-footer-small">Tư vấn khách hàng</h3>

                    <!-- advise list -->
                    <ul class="advise-list">
                        <li>
                            <div class="ic">
                                <img src="{{asset('template/images/black-phone-ic.png')}}" alt="phone" />
                            </div>
                            <div class="info">
                                <a href="tel:{{$def['hotline']}}">{{$def['hotline']}}</a>
                            </div>
                        </li>

                        <li>
                            <div class="ic">
                                <img src="{{asset('template/images/black-mail-ic.png')}}" alt="mail" />
                            </div>
                            <div class="info">
                                <a href="mailto:{{$def['email']}}">{{$def['email']}}</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>