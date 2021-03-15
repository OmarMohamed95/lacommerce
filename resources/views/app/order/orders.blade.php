@extends('layouts.app')
@section('content')
    @if(count($orders) > 0)
    <h3 class="text-center">Orders History</h3>
        @foreach ($orders as $order)
        <div class="order-container">
            <div class="order-code-container">
                <p>Order ID: <a href="{{ route('order_track', ['orderId' => $order->id]) }}">{{ $order->id }}</a></p>
                <p>Occured on: {{ $order->created_at->format('j F, Y - H:i:s') }}</p>
            </div>
            <table class="orders-table table" style="background-color: white">
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                </tr>
                @foreach ($order->products as $orderProduct)
                @php
                    $product = $orderProduct->product
                @endphp
                <tr>
                    <td>
                        <img src="{{ uploads('productImg/' . $product->productImg[0]->img) }}" class="wishlistImg">
                        {{ $product->name }}
                    </td>
                    <td>
                        {{ number_format($product->price) }}
                    </td>
                    <td>
                        {{ number_format($orderProduct->quantity) }}
                    </td>
                </tr>            
                @endforeach
            </table>
        </div>
        @endforeach
    @else
        <div class="row">
            <h3 class="text-center">Orders History</h3>
            <div class="notFound col-xs-offset-2 col-xs-8">
                <i class="far fa-frown fa-8x"></i>
                <p>No products found in your order history!</p>
                <a href="{{ url('/') }}">Go to Home page</a>
            </div>
        </div>
    @endif
@endsection