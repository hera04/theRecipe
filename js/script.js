$(window).load(function () {
	
    var top_margin = $(window).height() * 0.7;
    //alert(top_margin);

	$(document).scroll(function () {
	    $("#nav_top").toggleClass("nav_color", ($(this).scrollTop() > top_margin));
	    $("#nav_right").toggleClass("nav_color", ($(this).scrollTop() > top_margin));
        $("#profile_widget").toggleClass("profile_static_a", ($(this).scrollTop() > 0));
        $("#profile_widget").toggleClass("profile_static", ($(this).scrollTop() > top_margin));
	});

	
	$(window).resize(function () {
	    $("#page_container").toggleClass("container", ($(window).width() > 1366));
	});
	
	$('#trigger').on('click', function () {
	    $('#nav_right').toggleClass('open');
	})

});

$('a[href*=#]').click(function () {
    $('html, body').animate({
        scrollTop: $($(this).attr('href')).offset().top - 30
    }, 1500);
    return false;
});
	