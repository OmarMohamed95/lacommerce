$(document).ready(function(){
    $('.wishlistButton').on('click', function(e) {
        e.preventDefault();
        var thisElement = $(this),
            url = $(this).attr('href');

        axios.post(url)
        .then(function(response) {
            thisElement.children().removeClass('far fa-heart').addClass('fas fa-heart');
            showAndHideMessage(response.data.message);
        })
        .catch(function(error) {
            var message = error.response.data.message;
            if (error.response.status === 401) {
                message = 'Login first please!';
            }
            showAndHideMessage(message);
        })
    });

    $('.deleteWishlist').on('click', function(e) {
        e.preventDefault();

        var url = $(this).attr('href');

        axios.delete(url)
        .then(function(response) {
            $('.' + response.data.id).remove();
            showAndHideMessage(response.data.message);
        })
        .catch(function(error) {
            console.log(error)
        })
    });

    function showAndHideMessage(message)
    {
        $('.messageTop').text(message).fadeIn();
        setTimeout(function() {
            $('.messageTop').fadeOut();
        }, 3000);
    }
});