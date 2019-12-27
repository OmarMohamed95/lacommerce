@extends('layouts.app')
@section('content')
    @if (!empty($search))
    <div class="homeProductsContainer">
        @foreach ($search as $p)
            <div class="col-xs-12 col-md-4 homeProducts">
                <img src="{{ uploads("productImg/" . $p->productImg[0]->img) }}">
                <a href="{{ url('wishlist/store/' . $p->id) }}" class="wishlistButton pull-right"><i class="wishlist {{ (in_array($p->id, $wishlists))? 'fas fa-heart':'far fa-heart' }} fa-2x"></i></a>
                <p class="brand">{{ $p->brand->name }}</p>
                <a href="{{ url('product/index/' . $p->id) }}" style="text-decoration:none">
                    <p class="name">{{ strtoupper($p->name) }}</p>
                </a>
                <p class="price">{{ $p->price }} EGP</p>
                <a href="{{ url('cart/store/' . $p->id) }}" class="cartButton btn btn-success col-xs-12"><i class="fas fa-shopping-cart fa-1x"></i> Buy Now</a>
            </div>
        @endforeach
    </div>
    @else
        <div class="alert alert-danger">
            <p>Sorry, No results found!</p>
        </div>
    @endif
@endsection