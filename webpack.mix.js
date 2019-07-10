let mix = require('laravel-mix');

let npmPath = 'node_modules/';
let assetsPath = 'resources/assets/';
let publicPath = 'public/';

mix
   // JavaScript
   .js(assetsPath + 'js/app.js', publicPath + 'js')
   .js(assetsPath + 'js/app-datatable.js', publicPath + 'js')

   .copy([
      npmPath + 'datatables.net/js/jquery.dataTables.min.js',      
      npmPath + 'datatables.net-bs4/js/dataTables.bootstrap4.min.js',
      npmPath + 'select2/dist/js/select2.min.js'
   ], publicPath + 'js')

   // CSS
   .sass(assetsPath + 'sass/app.scss', publicPath + 'css')
   .sass(assetsPath + 'sass/select2.scss', publicPath + 'css')

   .copy([
      npmPath + 'datatables.net-bs4/css/dataTables.bootstrap4.min.css',
      npmPath + 'select2/dist/css/select2.min.css'
   ], publicPath + 'css')

   // Fonts
   .copy([
      assetsPath + 'fonts/',
      npmPath + 'font-awesome/fonts/'
   ], publicPath + 'fonts')

   // Images
   .copy([
      assetsPath + 'images/'
   ], publicPath + 'images')

   .options({
      processCssUrls: false
   });