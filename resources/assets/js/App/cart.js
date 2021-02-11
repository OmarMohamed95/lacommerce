$(document).ready(function(){
    // Delete product from cart
    $('.deleteCart').on('click', function(e){
        e.preventDefault();

        var url = $(this).attr('href');
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function(data){
                $('.' + data.id).remove();
                $('.messageTop').text(data.message).fadeIn();
                setTimeout(function(){
                    $('.messageTop').fadeOut();
                        }, 3000);
            },
        });
    });

    // Update product quantity in cart
    $('.quantity').on('change', function(){
        var productId = $(this).attr('role');
        var data = $(this).val();
        var url = "/cart/updateQuantity";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            data: {
                productId: productId,
                quantity: data,
            },
            method: 'POST',
            success: function(data){
                $('#quantity_validate').text('');
                
                $('.checkout_anchor').off('click');
            },
            error: function(e){

                $('.checkout_anchor').on('click', function(e){
                    e.preventDefault();
                });
                
                $('#quantity_validate').text(e.responseJSON.quantity[0]);
            },
        });
    });
});