@extends('layouts.app')
@section('content')
    @if($orders->count() > 0)
    <h3 class="text-center">Orders History</h3>
        <table class="wishlistTable table" style="background-color: white">
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Order Code</th>
                <th>Date</th>
            </tr>
            @foreach ($orders as $item)
            <tr>
                <td>
                    <img src="{{ uploads('productImg/' . $item->products->productImg[0]->img) }}" class="wishlistImg">
                    {{ $item->products->name }}
                </td>
                <td>
                    {{ $item->products->price }}
                </td>
                <td>
                    {{ $item->quantity }}
                </td>
                <td>
                    {{ $item->order_code }}
                </td>
                <td>
                    {{ $item->created_at }}
                </td>
            </tr>            
            @endforeach
        </table>
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