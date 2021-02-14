$(document).ready(function(){
    // submit tools select input on change
    //$('.tools').on('change', function(){
    //    $('#toolsForm').submit();
    //});

    // wishlist: add product to wishlist
    $('.wishlistButton').on('click', function(e){
        e.preventDefault();
        var thisE = $(this).children('.wishlist');
        var url = $(this).attr('href');
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'JSON',
            thisElement: thisE,
            success: function(data){
                this.thisElement.removeClass('far fa-heart').addClass('fas fa-heart');
                $('.messageTop').text(data.message).fadeIn();
                setTimeout(function(){
                    $('.messageTop').fadeOut();
                        }, 3000);
            },
            error: function(data){
                $.each(data.responseJSON, function(k, v){
                    if(v === 'Unauthenticated.'){
                        v = 'Login first please!';
                    }
                    $('.messageTop').text(v).fadeIn();
                    setTimeout(function(){
                        $('.messageTop').fadeOut();
                    }, 3000);
                });
            },
        });
    });

    // cart: add product to cart
    $('.cart-form').on('submit', function(e){
        e.preventDefault();
        var url = $(this).attr('action'),
            productId = $(this).find('input[name="id"]').val();

        axios.post(url, {
            productId: productId
        })
        .then(function (response) {
            if (response.status === 201) {
                $('body').css('overflow', 'hidden');
                $('.opacityBackground').show();
                $('.messageConfirm').show().prepend('<p>The product has been added to your cart.</p>' +
                "<button class='cartConfirm btn btn-success'>View Cart and Checkout</button> " +
                "<button class='cartCancel btn btn-primary'>Continue Shopping</button>"
                );

                // redirect to cart index page
                $('.cartConfirm').on('click', function(){
                    window.location.replace(response.data.redirect);
                });

                // continue shopping
                $('.cartCancel').on('click', function(){
                    $('body').css('overflow', 'visible');
                    $('.opacityBackground').hide();
                    $('.messageConfirm').hide();
                    $('.messageConfirm').children().remove();
                });
            } else if (response.status === 204) {
                $('body').css('overflow', 'hidden');
                $('.opacityBackground').show();
                $('.messageConfirm').show().prepend('<p>This product does not have more available stock.</p>' +
                "<button class='cartCancel btn btn-primary'>Continue Shopping</button>"
                );

                // continue shopping
                $('.cartCancel').on('click', function(){
                    $('body').css('overflow', 'visible');
                    $('.opacityBackground').hide();
                    $('.messageConfirm').hide();
                    $('.messageConfirm').children().remove();
                });

            }
        })
        .catch(function (error) {
            if (error.response.status === 401) {
                message = 'Login first please!';
            } else if (error.response.status >= 500) {
                message = 'Something wrong happend, please try again later!';
            }
            $('.messageTop').text(message).fadeIn();
            setTimeout(function(){
                $('.messageTop').fadeOut();
            }, 3000);
        })
    });
});