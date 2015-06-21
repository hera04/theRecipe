// Foundation JavaScript
// Documentation can be found at: http://foundation.zurb.com/docs
$(document).foundation();

$(window).load(function () {

    var top_margin = $(window).height() * 0.7;
    //alert(top_margin);

    $(document).scroll(function () {
        $("#navigation").toggleClass("small", ($(this).scrollTop() > 0));
        $("#siteContent").toggleClass("site-content-static", ($(this).scrollTop() > 0));
    });

    //if $(window).height() > 1024 {$("#siteContent").toggleClass("site-content");}

});

$('a[href*=#]').click(function () {
    $('html, body').animate({
        scrollTop: $($(this).attr('href')).offset().top - 30
    }, 1500);
    return false;
});