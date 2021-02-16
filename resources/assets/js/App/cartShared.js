$(document).ready(function() {
    $('#disableCart').on('click', function(e) {
        e.preventDefault();
        $('.messageTop').text("Login to be able to view your cart!").fadeIn();
        setTimeout(function() {
            $('.messageTop').fadeOut();
        }, 3000);
    });
});