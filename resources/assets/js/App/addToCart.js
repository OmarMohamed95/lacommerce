$(document).ready(function() {
    $('.cart-form').on('submit', function(e) {
        e.preventDefault();
        var url = $(this).attr('action'),
            productId = $(this).find('input[name="id"]').val();

        axios.post(url, {
            productId: productId
        })
        .then(function (response) {
            if (response.status === 201) {
                showConfirmMessage();

                $('.cartConfirm').on('click', function() {
                    window.location.replace(response.data.redirect);
                });
            } else if (response.status === 204) {
                showNoteMessage();
            }

            $('.cartCancel').on('click', function() {
                removeMessage();
            });
        })
        .catch(function (error) {
            if (error.response.status === 401) {
                message = 'Login first please!';
            } else if (error.response.status >= 500) {
                message = 'Something wrong happend, please try again later!';
            }
            $('.messageTop').text(message).fadeIn();
            setTimeout(function() {
                $('.messageTop').fadeOut();
            }, 3000);
        })
    });

    function showConfirmMessage()
    {
        prepareMessage();
        $('.messageConfirm').show().prepend(`
            <p>The product has been added to your cart.</p>
            <button class='cartConfirm btn btn-success'>View Cart and Checkout</button>
            <button class='cartCancel btn btn-primary'>Continue Shopping</button>
        `);
    }

    function showNoteMessage()
    {
        prepareMessage();
        $('.messageConfirm').show().prepend(`
            <p>This product does not have more available stock.</p>
            <button class='cartCancel btn btn-primary'>Continue Shopping</button>
        `);
    }

    function prepareMessage()
    {
        $('body').css('overflow', 'hidden');
        $('.opacityBackground').show();
    }

    function removeMessage()
    {
        $('body').css('overflow', 'visible');
        $('.opacityBackground').hide();
        $('.messageConfirm').hide();
        $('.messageConfirm').children().remove();
    }
});