let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
// if(1 ==0) {
    mix.styles([
        'public/html-viettech/css/owl.carousel.min.css',
        'public/html-viettech/css/owl.theme.default.min.css',
        'public/html-viettech/css/jquery.fancybox.min.css',
        'public/html-viettech/css/bootstrap-datetimepicker.min.css',
        'public/html-viettech/css/style.css',
        'public/html-viettech/css/custom.css',

    ], 'public/html-viettech/css/all.css').babel([
        'public/html-viettech/js/jquery-3.4.1.js',

        'public/html-viettech/js/bootstrap-rating.min.js',
        'public/html-viettech/js/bootstrap.min.js',
        
        'public/html-viettech/js/owl.carousel.min.js',
        'public/html-viettech/js/smooth-scroll.min.js',
        'public/html-viettech/js/jquery.fancybox.min.js',
        'public/js/library/popper.min.js',
        'public/html-viettech/js/magiczoom.js',
        'public/js/library/sweetalert2.all.min.js',
        'public/js/library/typeahead.bundle.min.js',

        'public/html-viettech/js/moment.min.js',
        'public/html-viettech/js/bootstrap-datetimepicker.min.js',


        'public/js/library/vue.js',

        'public/js/lazyload.js',

        'public/js/core.js',
        'public/js/app.js',
        'public/html-viettech/js/main.js',

    ], 'public/html-viettech/js/all.js');
// }

mix.styles([
    'public/mobile/css/owl.carousel.min.css',
    'public/mobile/css/owl.theme.default.min.css',
    'public/mobile/css/jquery.fancybox.min.css',
    'public/mobile/css/style.css',
    'public/mobile/css/custom.css',
], 'public/mobile/css/all.css').babel([
    'public/mobile/js/jquery-3.4.1.js',

    'public/mobile/js/bootstrap-rating.min.js',
    'public/mobile/js/bootstrap.min.js',

    'public/mobile/js/owl.carousel.min.js',
    'public/mobile/js/smooth-scroll.min.js',
    'public/mobile/js/jquery.fancybox.min.js',
    'public/mobile/js/magiczoom.js',

    'public/js/library/sweetalert2.all.min.js',

    'public/js/library/vue.js',
    
    'public/js/lazyload.js',
    // 'public/js/lang.js',
//        'js/library/jquery-latest.min.js',
    'public/js/core.js',
    'public/mobile/js/app.js',
    'public/mobile/js/main.js',
],'public/mobile/js/all.js');

///

