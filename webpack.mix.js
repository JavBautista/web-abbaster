const mix = require('laravel-mix');

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

mix.autoload({
    'jquery': ['$', 'window.jQuery', 'jQuery'],
    'vue': ['Vue','window.Vue'],
    'moment': ['moment','window.moment'],
  })
.sass('resources/sass/app.scss', 'public/css')
.js('resources/js/app.js', 'public/js')
.styles([
    'resources/coreui/css/font-awesome.min.css',
    'resources/coreui/css/simple-line-icons.min.css',
    'resources/coreui/css/style.css'
	],'public/css/coreui.css')
.scripts([
    /*'resources/coreui/js/jquery.min.js',
    'resources/coreui/js/popper.min.js',
    'resources/coreui/js/bootstrap.min.js',*/
    'resources/coreui/js/pace.min.js',
    'resources/coreui/js/Chart.min.js',
    'resources/coreui/js/template.js',
    'resources/coreui/js/sweetalert2.all.js'
    ],'public/js/coreui.js')
.styles([
    'resources/floating-whatsapp/css/floating-wpp.min.css',
    ],'public/css/fwhatsapp.min.css')
.scripts([
    'resources/floating-whatsapp/js/jquery-3.3.1.min.js',
    'resources/floating-whatsapp/js/floating-wpp.min.js',
    ],'public/js/fwhatsapp.min.js')
.scripts([
    'resources/coreui/js/sweetalert2.all.js'
    ],'public/js/sweetalert2.js');

mix.browserSync('http://abbaster.local/');