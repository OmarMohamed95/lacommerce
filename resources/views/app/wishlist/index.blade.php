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
                    {{ number_format($i->price) }}
                </td>
                <td>
                    <form action="{{ route('api_cart_store') }}" method="POST" class="cart-form">
                        <input type="hidden" name="id" value="{{ $i->id }}">
                        <button type="submit" class="cartButton btn btn-success col-xs-4">
                            <i class="fas fa-shopping-cart fa-1x"></i> Buy Now
                        </button>
                    </form>
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
    });
    </script>
@endsection