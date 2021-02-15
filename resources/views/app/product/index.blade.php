@extends('layouts.app')
@section('content')
<div class="row">
    <div class="productImgShowSlideContainer col-xs-1">
        <span id="up"><i class="fas fa-chevron-up fa-2x"></i></span>
        @foreach ($product->productImg as $key => $img)
        <img id="{{ $key }}" src="{{ uploads('productImg/' . $img->img) }}" class="productImgShowSlide">
        @endforeach 
        <span id="down"><i class="fas fa-chevron-down fa-2x"></i></span>
    </div>
    <div class="productImgShow col-xs-offset-2 col-md-offset-0 col-md-3"></div>
    <div class="productDetails col-md-7">
        <img src="{{ uploads('brandImg/' . $product->brand->img) }}" class="productBrandImg pull-right">
        <h3>{{ $product->name }}</h3>
        <p style="font-weight: bold">{{ $product->brand->name }}</p>  
        <hr>
        <p>{!! $product->desc !!}</p>
        <hr>
        <p class="productPrice col-xs-3">EGP {{ number_format($product->price) }}</p>
        <form action="{{ route('api_cart_store') }}" method="POST" class="cart-form">
            <input type="hidden" name="id" value="{{ $product->id }}">
            <button type="submit" class="cartButton btn btn-success col-xs-3 pull-right">
                <i class="fas fa-shopping-cart fa-1x"></i> Buy Now
            </button>
        </form>
        <div class="clearfix"></div>
        <a style="margin-top: 10px;" href="{{ url('wishlist/store/' . $product->id) }}" class="wishlistButton pull-right"><i class="wishlist {{ ($isWishlisted) ? 'fas fa-heart':'far fa-heart' }} fa-2x"></i></a>
        <p style="color:black">Available Quantity : {{ $product->quantity }}</p>
    </div>
    <div class="col-xs-12">
        <hr>
        <h2 class="text-center reviewH">reviews</h2>
        <form action="{{ route('product_review', ['productId' => $product->id]) }}" method="post" id="review">
            {{ csrf_field() }}
            <div class="form-group row">
                <div class="col-xs-12 col-md-5">
                    <textarea name="content" rows="4" class="reviewInput form-control" placeholder="Review this product here"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-xs-5 col-xs-offset-7 col-md-offset-0">
                    <input type="submit" value="review" class="btn btn-primary pull-right">
                </div>
            </div>
        </form>
        @if ($reviews->count() > 0)
        <div id="errorMsg"></div>
        <div class="showReviews">
                @foreach ($reviews as $review)
                    <div class="singleReview">
                        <p class="pull-right">{{ date('D, j F Y',strtotime($review->created_at)) }}</p>
                        <p class="reviewName">{{ $review->user->name }}</p>
                        <p>{!! nl2br($review->content) !!}</p>
                    </div>
                @endforeach
            </div>
        @else
            <div id="errorMsg"></div>
            <div class="showReviews"></div>
            <div class="alert alert-info text-center" id="noReviewsMsg">
                No reviews yet!
            </div>
        @endif
        
    </div> 
</div> 
@endsection

@section('script')
    @parent
    <script src="{{ mix('js/App/photoGallery.js') }}" type="text/javascript"></script>
    <script src="{{ mix('js/App/review.js') }}" type="text/javascript"></script>
@endsection