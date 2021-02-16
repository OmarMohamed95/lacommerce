@extends('layouts.app')
@section('content')
    @if (!empty($search))
    <div class="homeProductsContainer">
        @foreach ($search as $p)
            <div class="col-xs-12 col-md-4 homeProducts">
                <img src="{{ uploads("productImg/" . $p->productImg[0]->img) }}">
                <a href="{{ route('wishlist_product_store', ['productId' => $p->id]) }}" class="wishlistButton pull-right"><i class="wishlist {{ (in_array($p->id, $wishlists))? 'fas fa-heart':'far fa-heart' }} fa-2x"></i></a>
                <p class="brand">{{ $p->brand->name }}</p>
                <a href="{{ route('product_index', ['id' => $p->id]) }}" style="text-decoration:none">
                    <p class="name">{{ strtoupper($p->name) }}</p>
                </a>
                <p class="price">{{ $p->price }} EGP</p>
                <form action="{{ route('api_cart_store') }}" method="POST" class="cart-form">
                    <input type="hidden" name="id" value="{{ $p->id }}">
                    <button type="submit" class="cartButton btn btn-success col-xs-12">
                        <i class="fas fa-shopping-cart fa-1x"></i> Buy Now
                    </button>
                </form>
            </div>
        @endforeach
    </div>
    @else
        <div class="alert alert-danger">
            <p>Sorry, No results found!</p>
        </div>
    @endif
@endsection
@section('script')
    @parent
    <script src="{{ mix('js/App/wishlist.js') }}" type="text/javascript"></script>
    <script src="{{ mix('js/App/addToCart.js') }}" type="text/javascript"></script>
@endsection