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

// Registration and Login Pages
mix.copy('vendor/components/jquery/jquery.min.js', 'public/js/');
mix.js('vendor/twbs/bootstrap/dist/js/bootstrap.min.js', 'public/js/app.js');

mix.styles('vendor/twbs/bootstrap/dist/css/bootstrap.min.css', 'public/css/app.css');
mix.copy([
    'resources/assets/css/toastr.min.css',
    'resources/assets/css/fullcalendar.min.css',
    'resources/assets/css/float-label-control.css',
    'resources/assets/css/bootstrap-multiselect.css',
    'resources/assets/css/fullcalendar.print.min.css',
    'vendor/twbs/bootstrap/dist/css/bootstrap.min.css.map',
    'resources/assets/css/font-awesome.css'], 'public/css/');
mix.copy('vendor/twbs/bootstrap/dist/fonts', 'public/fonts');
mix.copy([
    'resources/assets/js/carquery.js',
    'resources/assets/js/mycalendar.js',
    'resources/assets/js/vehicledocument.js',
    'resources/assets/js/fullcalendar.min.js',
    'resources/assets/js/float-label-control.js',
    'resources/assets/js/bootstrap-multiselect.js',
    'resources/assets/js/toastr.min.js'], 'public/js');
    
// Utility files
//mix.copyDirectory('resources/assets/img', 'public/images');
// mix.copy('resources/assets/js/bootstrap-editable.js', 'public/js');
// mix.copy('resources/assets/css/bootstrap-editable.css', 'public/css');

 mix.styles([
    'vendor/twbs/bootstrap/dist/css/bootstrap.min.css',
    'resources/assets/css/bootstrap-editable.css',
    'resources/assets/css/frontend.css'], 'public/css/frontend.css');

mix.js([
   'resources/assets/js/jquery.js',
   'vendor/twbs/bootstrap/dist/js/bootstrap.min.js',
   'resources/assets/js/bootstrap-editable.js',
   'resources/assets/js/frontend.js'], 'public/js/frontend.js');

// Copy DataTables files needed over to the public folder.
mix.copyDirectory('vendor/datatables/datatables/media/js', 'public/js');
mix.copyDirectory('vendor/datatables/datatables/media/css', 'public/css');
// mix.copyDirectory('vendor/datatables/datatables/media/images', 'public/images');

if (mix.inProduction()) {
    mix.version();
    mix.disableNotifications();
} else {
    mix.browserSync(process.env.MIX_SENTRY_DSN_PUBLIC);
}
