@extends('layouts.app')
@section('content')
    @if($wishlist->count() > 0)
    <h3 class="text-center">Wishlist</h3>
        <table class="wishlistTable table" style="background-color: white">
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th></th>
                <th></th>
            </tr>
            @foreach ($wishlist as $item)
            @foreach ($item->products as $i)
            <tr class="{{ $i->id }}">
                <td>
                    <img src="{{ uploads('productImg/' . $i->productImg[0]->img) }}" class="wishlistImg">
                    {{ $i->name }}
                </td>
                <td>
                    {{ $i->price }}
                </td>
                <td>
                    <a href="{{ url('cart/store/' . $i->id) }}" class="cartButton btn btn-success"><i class="fas fa-shopping-cart fa-1x"></i> Buy Now</a>
                </td>
                <td>
                    <a href="{{ url('wishlist/delete/' . $i->id) }}" class="deleteWishlist"><i class="fas fa-trash-alt fa-2x deleteIcon"></i></a>
                </td>
            </tr>            
            @endforeach
            @endforeach
        </table>
    @else
    <div class="row">
        <h3 class="text-center">Wishlist</h3>
        <div class="notFound col-xs-offset-2 col-xs-8">
            <i class="far fa-frown fa-8x"></i>
            <p>No products found in your wishlist!</p>
            <a href="{{ url('/') }}">Go to Home page</a>
        </div>
    </div>
    @endif
@endsection
@section('script')
@parent
    <script type="text/javascript">
    $(document).ready(function(){
        // delete product from wishlist
        $('.deleteWishlist').on('click', function(e){
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
                            $('.messageTop').text(v).fadeIn();
                            setTimeout(function(){
                                $('.messageTop').fadeOut();
                            }, 3000);
                        });
                    },
                });
            });
    });
    </script>
@endsection