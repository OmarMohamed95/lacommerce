@extends('layouts.app')
@section('content')
    <div class="addressDetails addressDetailsMain">
        <h3>ORDER DETAILS</h3>
        <table class="wishlistTable table" style="background-color: white">
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>
            @foreach ($cart as $key => $item)
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
                <td class="quantity{{$key}}">
                    {{ $item->quantity }}
                </td>
            </tr>            
            @endforeach
        </table>
        <div class="totalPrice">
            <p id="total" style="font-weight: bold;"></p>
        </div>
    </div>    
    <div class="addressDetails">
        <h3>DELIVERY METHOD</h3>
        <p>Delivered within 3 to 5 days.</p>
        <p class="bold">Get delivered at your door step !</p>
    </div>
    <div class="addressDetails">
        <h3>ADDRESS DETAILS</h3>
        <form action="{{ url('checkout/checkout/' . auth()->user()->id) }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="Address" class="col-xs-2 col-form-label">Address</label>
                <div class="col-xs-6">
                    <input type="text" name="address" class="form-control" placeholder="Address">
                </div>
            </div>
            <div class="form-group row">
                <label for="Phone" class="col-xs-2 col-form-label">Phone</label>
                <div class="col-xs-6">
                    <input type="text" name="phone" class="form-control" placeholder="Phone">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-8">
                    <input type="submit" value="submit" class="btn btn-primary pull-right">
                </div>
            </div>
        </form>
    </div>    
@endsection