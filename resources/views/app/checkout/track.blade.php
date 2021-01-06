@extends('layouts.app')
@section('content')
    @inject('orderStates', 'App\Constants\CheckoutStates')
    @php
        $orderState = $order->first()->state;
    @endphp
    <div class="addressDetails">
        <h3>ORDER State</h3>
        <div class="col-xs-offset-1">
            @if ( in_array($orderState, [$orderStates::PREPARING, $orderStates::PENDING]))
                <p class="col-xs-4" style="color: black"><i class="fas fa-box-open fa-4x"></i></p>
                <p class="col-xs-4" style="color: #ddd"><i class="fas fa-shipping-fast fa-4x"></i></p>
                <p class="col-xs-4" style="color: #ddd"><i class="fas fa-handshake fa-4x"></i></p>
                <p class="bold">Your order is being prepared</p>
            @elseif($orderState === $orderStates::SHIPPED)
                <p class="col-xs-4" style="color: #ddd"><i class="fas fa-box-open fa-4x"></i></p>
                <p class="col-xs-4" style="color: black"><i class="fas fa-shipping-fast fa-4x"></i></p>
                <p class="col-xs-4" style="color: #ddd"><i class="fas fa-handshake fa-4x"></i></p>    
                <p class="bold col-xs-offset-4">Your order is shipped</p>
            @elseif($orderState === $orderStates::DELIVERED)
                <p class="col-xs-4" style="color: #ddd"><i class="fas fa-box-open fa-4x"></i></p>
                <p class="col-xs-4" style="color: #ddd"><i class="fas fa-shipping-fast fa-4x"></i></p>
                <p class="col-xs-4" style="color: black"><i class="fas fa-handshake fa-4x"></i></p>    
                <p class="bold col-xs-offset-8">Your order is delivered</p>
            @endif
        </div>
    </div>
    <div class="addressDetails">
        <h3>ORDER DETAILS</h3>
        <h3>ORDER CODE : {{ $order->first()->order_code }}</h3>
        <table class="wishlistTable table" style="background-color: white">
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>
            @foreach ($order as $i)
            <tr>
                <td>
                    {{ $i->products->name }}
                </td>
                <td>
                    {{ $i->products->price }}
                </td>
                <td>
                    {{ $i->quantity }}
                </td>
            </tr>            
            @endforeach
        </table>
    </div>    
    <div class="addressDetails">
        <h3>Personal Details</h3>
        <p>Address : {{ $order->first()->address }}</p>
        <p>Phone : {{ $order->first()->phone }}</p>
    </div>    

@endsection