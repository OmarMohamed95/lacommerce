@extends('layouts.app')
@section('content')
    @if(count($orders) > 0)
    <h3 class="text-center">Orders History</h3>
        @foreach ($orders as $orderCode => $orderGroup)
        <div class="order-container">
            <div class="order-code-container">
                <p>Order Code: <a href="{{ route('checkout_track_code', ['orderCode' => $orderCode]) }}">{{ $orderCode }}</a></p>
                <p>Occured on: {{ $orderGroup[0]->created_at->format('j F, Y - H:i:s') }}</p>
            </div>
            <table class="orders-table table" style="background-color: white">
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                </tr>
                @foreach ($orderGroup as $order)
                <tr>
                    <td>
                        <img src="{{ uploads('productImg/' . $order->products->productImg[0]->img) }}" class="wishlistImg">
                        {{ $order->products->name }}
                    </td>
                    <td>
                        {{ $order->products->price }}
                    </td>
                    <td>
                        {{ $order->quantity }}
                    </td>
                </tr>            
                @endforeach
            </table>
        </div>
        @endforeach
        @else
    <div class="row">
        <h3 class="text-center">Wishlist</h3>
        <div class="notFound col-xs-offset-2 col-xs-8">
            <i class="far fa-frown fa-8x"></i>
            <p>No products found in your order history!</p>
            <a href="{{ url('/') }}">Go to Home page</a>
        </div>
    </div>
    @endif
@endsection