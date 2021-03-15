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
                    {{ number_format($product->price) }}
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
                    <a href="{{ route('api_cart_delete', ['productId' => $product->id]) }}" class="deleteCart"><i class="fas fa-trash-alt fa-2x deleteIcon"></i></a>
                </td>
            </tr>            
            @endforeach
        </table>
        <div class="total-price-container">
            <p>Total price</p>
            <p id="totalPrice">{{ number_format($totalPrice) }}</p>
        </div>
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="pull-right">
            <p id="total" style="font-weight: bold;"></p>
            <a href="{{ url('order') }}" class="btn btn-success checkout_anchor"><i class="fas fa-shopping-cart fa-1x"></i> CHECKOUT</a>
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
    <script src="{{ mix('js/App/cart.js') }}" type="text/javascript"></script>
@endsection