jQuery(document).ready(function($){

    $('#accessible-wp-skiplinks .nav-tab').click(function (e) {
        e.preventDefault();
        var tab = $(this).attr('href');

        $('.acwp-tab').each(function () {
            $(this).removeClass('active');
        });

        $(tab).addClass('active');

        $('.nav-tab').each(function () {
            $(this).removeClass('nav-tab-active');
        });

        $(this).addClass('nav-tab-active');
    });

    // Activate wp color picker
    $('.color-field').each(function(){
        $(this).wpColorPicker();
    });

});
