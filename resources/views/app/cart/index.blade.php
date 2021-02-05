@extends('layouts.app')
@section('content')
    @if($cartProducts->count() > 0)
    <h3 class="text-center">Cart</h3>
        <table class="wishlistTable table" style="background-color: white">
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th></th>
                <th></th>
            </tr>
            @foreach ($cartProducts as $key => $item)
            @php
                $product = $item->product
            @endphp
            <tr class="{{ $product->id }}">
                <td>
                    <img src="{{ uploads('productImg/' . $product->productImg[0]->img) }}" class="wishlistImg">
                    {{ $product->name }}
                </td>
                <td class="price{{$key}}">
                    {{ $product->price }}
                </td>
                <td>
                    <div class="form-group row">
                        <div class="col-xs-3">
                            <input type="number" max="{{$product->quantity}}" min="1" name="quantity" role="{{$product->id}}" value="{{ $cartProducts[$key]->quantity }}" class="form-control quantity quantity{{$key}}" placeholder="Quantity">
                        </div>
                    </div>
                    <span id="quantity_validate" class="error" style="color:red"></span>
                    <p style="color:black">Available Quantity : {{ $product->quantity }}</p>
                </td>
                <td>
                    <a href="{{ url('cart/delete/' . $product->id) }}" class="deleteCart"><i class="fas fa-trash-alt fa-2x deleteIcon"></i></a>
                </td>
            </tr>            
            @endforeach
        </table>
        <div class="pull-right">
            <p id="total" style="font-weight: bold;"></p>
            <a href="{{ url('checkout') }}" class="btn btn-success checkout_anchor"><i class="fas fa-shopping-cart fa-1x"></i> CHECKOUT</a>
        </div>
    @else
    <div class="row">
        <h3 class="text-center">Cart</h3>
        <div class="notFound col-xs-offset-2 col-xs-8">
            <i class="far fa-frown fa-8x"></i>
            <p>No products found in your cart!</p>
            <a href="{{ url('/') }}">Go to Home page</a>
        </div>
    </div>
    @endif
@endsection
@section('script')
@parent
    <script type="text/javascript">
    $(document).ready(function(){
        // calculate total price
        /**total();

        $('.quantity').on('change', function(){
            total();
        });

        function total(){

        var total = 0;
        for(var i = 0; i < {{ $cartProducts->count() }}; i++){
            var productPrice = $(`.price${i}`).text();
            var quantity = $(`.quantity${i}`).val();
            if(quantity <= 0){
                quantity = 1;
            }
            var price = productPrice * quantity;

            total += price;
        }

        $('#total').text(`Total: ${total} EGP`);

        }**/

        // delete product from wishlist
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

        // update product quantity in cart
        $('.quantity').on('change', function(){
            var productId = $(this).attr('role');
            var data = $(this).val();
            var url = "{{ url('cart/updateQuantity') }}";

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: url,
                data: {
                    userId: {{auth()->user()->id}},
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
    </script>
@endsection