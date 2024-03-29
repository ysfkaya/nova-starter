let mix = require('laravel-mix')

mix.setPublicPath('dist')
    .js('resources/js/tool.js', 'js')
    .sass('resources/sass/tool.scss', 'css')
    .webpackConfig({
        resolve: {
            alias: {
                '@': path.resolve(__dirname, '../../vendor/laravel/nova/resources/js/')
            }
        }
    });
