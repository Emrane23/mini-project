const Encore = require('@symfony/webpack-encore');
const webpack = require('webpack'); 

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')

    // Ajoutez vos fichiers CSS et JS comme avant
    .addStyleEntry('bo-styles', './assets/styles/BO/css/sb-admin-2.min.css')
    .addEntry('bo-scripts', [
        './assets/styles/BO/vendor/jquery/jquery.min.js',
        './assets/styles/BO/vendor/bootstrap/js/bootstrap.bundle.min.js',
        './assets/styles/BO/vendor/jquery-easing/jquery.easing.min.js',
        './assets/styles/BO/js/sb-admin-2.min.js',
    ])
    // Scripts spécifiques aux graphiques
    .addEntry('bo-charts', [
        './assets/styles/BO/vendor/chart.js/Chart.min.js',
        './assets/styles/BO/js/demo/chart-area-demo.js',
        './assets/styles/BO/js/demo/chart-pie-demo.js',
    ])

    // Ajoutez le plugin ProvidePlugin avec addPlugin()
    .addPlugin(new webpack.ProvidePlugin({
        $: 'jquery',          // jQuery est disponible globalement
        jQuery: 'jquery',     // jQuery est disponible globalement
        'window.jQuery': 'jquery', // jQuery accessible via window.jQuery
    }))

    // Autres configurations (comme la copie des fichiers)
    .copyFiles({
        from: './assets/styles/BO/img',
        to: 'images/[path][name].[ext]',
    })
    .copyFiles({
        from: './assets/styles/BO/vendor/fontawesome-free/webfonts',
        to: 'webfonts/[path][name].[ext]',
    })
    .enableSingleRuntimeChunk()
    .enableSassLoader()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction());

module.exports = Encore.getWebpackConfig();
