@extends('layouts.app')

@section('content')
    @if ($offers->count() > 0)        
    <!-- slider start -->
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            @for ($i = 0; $i < $offers->count(); $i++)    
                <li data-target="#carousel-example-generic" data-slide-to="{{ $i }}"></li>
            @endfor
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            @foreach ($offers as $key => $v)
            @if($key === 0)
                <div class="item active">
                    <a href="{{ url('product/index/' . $v->id) }}" style="text-decoration:none">
                        @if ($v->productImg->count() > 0)
                        <img src="{{ uploads('productImg/' . $v->productImg[0]->img) }}" style="width: 100%; height: 500px;">
                        @else
                        <img src="{{ uploads('productImg/unknown') }}" style="width: 100%; height: 500px;">
                        @endif
                        <div class="carousel-caption">
                            <h3><?php echo strtoupper($v['name']); ?></h3>
                            <p><?php echo $v['price']; ?> EGP</p>
                        </div>
                    </a>
                </div>
            @else
                <div class="item">
                    <a href="{{ url('product/index/' . $v->id) }}" style="text-decoration:none">
                        @if ($v->productImg->count() > 0)
                        <img src="{{ uploads('productImg/' . $v->productImg[0]->img) }}" style="width: 100%; height: 500px;">
                        @else
                        <img src="{{ uploads('productImg/unknown') }}" style="width: 100%; height: 500px;">
                        @endif
                        <div class="carousel-caption">
                            <h3><?php echo strtoupper($v['name']); ?></h3>
                            <p><?php echo $v['price']; ?> EGP</p>
                        </div>
                    </a>                            
                </div>
            @endif
            @endforeach
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="icon-prev" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="icon-next" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    @endif
    <!-- slider end -->
    <!-- product by category start -->
    @if (isset($homeCategoryProducts))
    <div class="homeProductsContainer">
        @foreach ($homeCategoryProducts as $item)
            <h3>{{ strtoupper($item->name) }}</h3>
            @foreach ($item->products->take(3) as $p)
            <div class="col-xs-12 col-md-4 homeProducts">
                <img src="{{ uploads("productImg/" . $p->productImg[0]->img) }}">
                <a href="{{ url('wishlist/store/' . $p->id) }}" class="wishlistButton pull-right"><i class="wishlist {{ (in_array($p->id, $wishlistProducts))? 'fas fa-heart':'far fa-heart' }} fa-2x"></i></a>
                <p class="brand">{{ $p->brand->name }}</p>
                <a href="{{ url('product/index/' . $p->id) }}" style="text-decoration:none">
                    <p class="name">{{ strtoupper($p->name) }}</p>
                </a>
                <p class="price">{{ $p->price }} EGP</p>
                <a href="{{ url('cart/store/' . $p->id) }}" class="cartButton btn btn-success col-xs-12"><i class="fas fa-shopping-cart fa-1x"></i> Buy Now</a>                
            </div>
            @endforeach
        <div class="clearfix"></div>
        @endforeach
    </div>
    @endif
    <!-- product by category end -->
@endsection