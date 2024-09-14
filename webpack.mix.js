const mix = require('laravel-mix');

mix.copy('node_modules/nouislider/dist/nouislider.min.js', 'public/js/vendor/nouislider/');
// mix.copy('node_modules/nouislider/dist/nouislider.min.css', 'public/css/');