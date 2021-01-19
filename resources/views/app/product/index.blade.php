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
        <p class="productPrice col-xs-3">EGP {{ $product->price }}</p>
        <a href="{{ url('cart/store/' . $product->id) }}" class="cartButton btn btn-success col-xs-3 pull-right"><i class="fas fa-shopping-cart fa-1x"></i> Buy Now</a>
        <div class="clearfix"></div>
        <a style="margin-top: 10px;" href="{{ url('wishlist/store/' . $product->id) }}" class="wishlistButton pull-right"><i class="wishlist {{ ($isWishlisted) ? 'fas fa-heart':'far fa-heart' }} fa-2x"></i></a>
        <p style="color:black">Available Quantity : {{ $product->quantity }}</p>
    </div>
    <div class="col-xs-12">
        <hr>
        <h2 class="text-center reviewH">reviews</h2>
        <form action="{{ url('review/' . $product->id) }}" method="post" id="review">
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
    <script type="text/javascript">
        $(document).ready(function(){

            // image slide show arrows
            var i = 0;
            var imgCount = $('.productImgShowSlide').length;
            var noOfImagesToDisplay = 2;

            $('.productImgShowSlide').slice(noOfImagesToDisplay).hide();

            function up(){
                if(i >= imgCount - noOfImagesToDisplay){

                    return false;
                }

                $('#'+i).hide(200);
                $('#'+parseFloat(i + noOfImagesToDisplay)).show(200);

                i = i + 1;
                
            }

            function down(){
                if(i === 0){

                    return false;
                }

                $('#'+parseFloat(i + 1)).hide(200);
                $('#'+parseFloat(i - 1)).show(200);

                i = i - 1;
                
            }

            $('#up').on('click', function(){
                up();
                $(this).animate({ "color": "#ddd" },100)
                .delay(1)
                .animate({ "color": '#636b6f' },100);
            });

            $('#down').on('click', function(){
                down();
                $(this).animate({ "color": "#ddd" },100)
                .delay(1)
                .animate({ "color": '#636b6f' },100);
            });

            // image slide show
            var productImgShow = $('.productImgShow');
            $('.productImgShowSlide').on('mouseenter', function(){
                $(productImgShow).children().remove();
                $(this).clone().removeClass('productImgShowSlide').appendTo(productImgShow);
            });

            $('.productImgShowSlide').first().trigger('mouseenter');

            // review ajax
            $('#review').on('submit',function(e){
                e.preventDefault();
                var data = $(this).serialize();
                var url = $(this).attr('action');

                $.ajax({
                    url: url,
                    data: data,
                    method: 'POST',
                    dataType: 'json',
                    success: function(r){

                        $('#errorMsg').hide();

                        var date = new Date(r.review.created_at);
                        var options = { weekday: 'short', month: 'long', day: 'numeric', year: 'numeric' };
                        var dateToStr = date.toLocaleDateString(false, options);

                        $('.showReviews').prepend("<div class='singleReview'>" +
                            "<p class='pull-right'>" + dateToStr + "</p>" + 
                            "<p class='reviewName'>" + r.review.user.name  + "</p>" + 
                            "<p>" +  r.review.content  + "</p>" + 
                            "</div>"
                        );

                    },
                    error: function(data){

                        $('#errorMsg').show();

                        $.each(data.responseJSON, function(k, v){
                            $('#errorMsg').addClass('alert alert-danger text-center').text(v);
                        });

                    },
                    complete: function(){
                        $('#review').trigger('reset');
                        $('#noReviewsMsg').remove();
                    }
                });

            });

        });
    </script>
@endsection