const mix = require('laravel-mix');

// Example of compiling JS and SASS files
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .version();  // For cache busting (optional)
