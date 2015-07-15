// Foundation JavaScript
// Documentation can be found at: http://foundation.zurb.com/docs
$(document).foundation();

$(window).load(function () {

    var top_margin = $(window).height() * 0.7;
    //alert($(window).width());

    $(document).scroll(function () {
        $("#navigation").toggleClass("add_shadow", ($(this).scrollTop() > ($(window).height() - 100)));
        $("#navigation_base").toggleClass("add_shadow", ($(this).scrollTop() > 0));
        $("#siteContent").toggleClass("site-content-static", ($(this).scrollTop() > 0));
    });

    //if ( $(window).width() > 1024) { $("#siteContent").toggleClass("site-content-large"); }

});

$('a[href*=#]').click(function () {
    $('html, body').animate({
        scrollTop: $($(this).attr('href')).offset().top - 30
    }, 1500);
    return false;
});