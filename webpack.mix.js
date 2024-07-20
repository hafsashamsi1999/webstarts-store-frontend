const mix = require('laravel-mix');
require('laravel-mix-simple-image-processing');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

const tailwindcss = require('tailwindcss')

mix.setPublicPath('public');

//console.log(process.env.MIX_SENTRY_DSN_PUBLIC);

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/home.scss', 'public/css')
    .sass('resources/sass/style.scss', 'public/css')
    .sass('resources/sass/testimonialslider.scss', 'public/css')
    .sass('resources/sass/index-offers.scss', 'public/css')
    .sass('resources/sass/index-pricing.scss', 'public/css')
    .sass('resources/sass/index-app.scss', 'public/css')
    .sass('resources/sass/faq.scss', 'public/css')
    .sass('resources/sass/checkout-page.scss', 'public/css')
    .sass('resources/sass/blog-page.scss', 'public/css')
    .sass('resources/sass/design-page.scss', 'public/css')
    .sass('resources/sass/example-page.scss', 'public/css')
    .sass('resources/sass/pricing-page.scss', 'public/css')
    .sass('resources/sass/templates-page.scss', 'public/css')
    .sass('resources/sass/template-categories.scss', 'public/css')
    .sass('resources/sass/test.scss', 'public/css')
    .options({
        postCss: [ tailwindcss('./tailwind.config.js') ],
        processCssUrls: false
    })
    .version();

mix.js('resources/js/common.js', 'public/js').version();
mix.js('resources/js/templates.js', 'public/js').version();
mix.js('resources/js/domains.js', 'public/js').version();
mix.js('resources/js/home.js', 'public/js').version();
mix.js('resources/js/signup.js', 'public/js').version();
mix.js('resources/js/login.js', 'public/js').version();
mix.js('resources/js/forgot.js', 'public/js').version();
mix.js('resources/js/reset-password.js', 'public/js').version();

mix.imgs({
    source: 'resources/images',
    destination: 'public/images',
    thumbnailsSuffix: '_w',
    thumbnailsSizes: [300, 500, 750, 1000, 1500, 1920],
    thumbnailsWebp: true,
    smallerThumbnailsOnly: true,
    processOriginalImage: false,
});