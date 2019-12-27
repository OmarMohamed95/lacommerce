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
    $('.cartButton').on('click', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'JSON',
            success: function(data){
                if(data.available === true){

                $('body').css('overflow', 'hidden');
                $('.opacityBackground').show();
                $('.messageConfirm').show().prepend('<p>' + data.msg + '</p>' +
                "<button class='cartConfirm btn btn-success'>" + data.confirm + "</button> " +
                "<button class='cartCancel btn btn-primary'>" + data.cancel + "</button>"
                );

                // redirect to cart index page
                $('.cartConfirm').on('click', function(){
                    window.location.replace(data.redirect);
                });

                // continue shopping
                $('.cartCancel').on('click', function(){
                    $('body').css('overflow', 'visible');
                    $('.opacityBackground').hide();
                    $('.messageConfirm').hide();
                    $('.messageConfirm').children().remove();
                });

                }else if(data.available === false){

                    $('body').css('overflow', 'hidden');
                    $('.opacityBackground').show();
                    $('.messageConfirm').show().prepend('<p>' + data.msg + '</p>' +
                    "<button class='cartCancel btn btn-primary'>" + data.cancel + "</button>"
                    );

                    // continue shopping
                    $('.cartCancel').on('click', function(){
                    $('body').css('overflow', 'visible');
                    $('.opacityBackground').hide();
                    $('.messageConfirm').hide();
                    $('.messageConfirm').children().remove();
                });

                }
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
});