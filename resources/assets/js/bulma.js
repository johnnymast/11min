jQuery(function () {

    var toggle = $('.nav-toggle');
    var menu = $('.nav-menu');

    toggle.on('click', function () {
        $(this).toggleClass('is-active');
        menu.toggleClass('is-active');
    });
});