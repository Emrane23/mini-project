import '../bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import '../styles/app.scss';

$('.custom-file-input').on('change', function (event) {
    var inputFile = event.currentTarget ;
    $(inputFile).parent().find('.custom-file-label').html(inputFile.files[0].name)
 })
 