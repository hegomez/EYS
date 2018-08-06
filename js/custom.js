$(document).ready(function () {
    "use strict"; // Start of use strict       
    $('body').append('<div id="toTop" class="btn back-top"><span class="ti-arrow-up"></span></div>');
    $(window).on("scroll", function () {
        if ($(this).scrollTop() !== 0) {
            $('#toTop').fadeIn();
        } else {
            $('#toTop').fadeOut();
        }
    });
    $('#toTop').on("click", function () {
        $("html, body").animate({scrollTop: 0}, 600);
        return false;
    });
    $(".max-menu").hide();
    $(".min-menu").click(function(){
        $(".max-menu").fadeIn();
        $(".min-menu").fadeOut();
    });
    $(".max-menu").click(function(){
        $(".min-menu").fadeIn();
        $(".max-menu").fadeOut();
    });
});