$(document).ready(function(){
    // Delete product from cart
    $('.deleteCart').on('click', function(e){
        e.preventDefault();

        var url = $(this).attr('href');
        axios.delete(url)
        .then(function(response) {
            $('.' + response.data.id).remove();
            $('.messageTop').text(response.data.message).fadeIn();
            setTimeout(function() {
                $('.messageTop').fadeOut();
            }, 3000);
        })
        .catch(function(error) {
            console.log(error)
        })
    });

    // Update product quantity in cart
    $('.quantity').on('keyup', function(){
        var productId = $(this).attr('role'),
            data = $(this).val(),
            url = `/api/carts/${productId}/quantity`;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            data: {
                quantity: data,
            },
            method: 'PUT',
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

        //Get total price
        axios.get(`/api/carts/total-price`)
        .then(function (response) {
            $('#totalPrice').text(new Intl.NumberFormat().format(response.data.totalPrice));
        })
        .catch(function (error) {
            console.log(error);
        })
    });
});