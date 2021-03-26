@extends('admin.layouts.adminTemplate')
@section('content')
    <h1>Overview</h1>
    <hr>
    <h3>Details</h3>
    <table class="table table-hover">
        <tr>
            <th>User ID</th>
            <td>{{ $order->user_id }}</td>
        </tr>
        <tr>
            <th>Username</th>
            <td>{{ $order->user->name }}</td>
        </tr>
        <tr>
            <th>Date</th>
            <td>{{ $order->created_at }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>{{ $order->address }}</td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>{{ $order->phone }}</td>
        </tr>
    </table>
    <hr>
    <h3>Products</h3>
    <table class="wishlistTable table" style="background-color: white">
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
                {{ number_format($orderProduct->price) }}
            </td>
            <td>
                {{ number_format($orderProduct->quantity) }}
            </td>
        </tr>            
        @endforeach
    </table>
    <p>Total price: {{ $totalPrice }}</p>
@endsection