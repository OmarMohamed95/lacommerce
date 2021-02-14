@extends('layouts.app')
@section('content')
        <div class="homeProductsContainer">
            <h3>{{ strtoupper($category->name) }}</h3>
            <p style="color: grey; text-align: center;">{{ $products->total() }} products found</p>
            <hr>
            <form action="{{ url('category/' . $category->id) }}" method="get" id="toolsForm">
                {{ csrf_field() }}
                <div class="form-group row toolsWrap">
                    <div class="col-xs-offset-1 col-xs-10">
                        <div class="col-xs-6 col-md-2 tool">
                            <input type="number" name="price[min]" class="form-control" placeholder="Min" value="{{ request()->price['max'] && request()->price['min'] > request()->price['max'] ? request()->price['max'] : request()->price['min'] }}">
                        </div>
                        <div class="col-xs-6 col-md-2 tool">
                            <input type="number" name="price[max]" class="form-control" placeholder="Max" value="{{ request()->price['max'] && request()->price['min'] > request()->price['max'] ? request()->price['min'] : request()->price['max'] }}">
                        </div>
                        <div class="col-xs-6 col-md-2 tool">
                            <select name="sort_by" class="form-control tools">
                                <option value="" hidden selected>Sort By</option>
                                <option value="created_at/desc" {{ (request()->sort_by == "created_at/desc")? 'selected':'' }}>Newest</option>                        
                                <option value="created_at/asc" {{ (request()->sort_by == "created_at/asc")? 'selected':'' }}>Oldest</option>                        
                                <option value="price/asc" {{ (request()->sort_by == "price/asc")? 'selected':'' }}>Lowest Price</option>                        
                                <option value="price/desc" {{ (request()->sort_by == "price/desc")? 'selected':'' }}>Highest Price</option>                        
                            </select>
                        </div>
                        @if(isset($category->brands))
                        <div class="col-xs-6 col-md-2 tool">
                            <select name="brand" class="form-control tools">
                                <option value="" hidden selected>Brand</option>
                                @foreach ($category->brands as $item)
                                    <option value="{{ $item->id }}" {{ (request()->brand == $item->id)? 'selected':'' }}>{{ $item->name }}</option>                                                            
                                @endforeach
                            </select>
                        </div>
                        @endif
                        @if($customFields->isNotEmpty())
                            @foreach ($customFields as $k => $i)
                                @if ($i->customField->count() > 0)    
                                    <div class="col-xs-6 col-md-2 tool">
                                        <select name="custom_field[{{$i->name}}]" class="form-control tools">
                                            <option value="" hidden selected>{{$i->customField->first()->name}}</option>
                                            @foreach ($i->customFieldProduct->unique('value') as $p)
                                            <option value="{{ $p->value }}" {{ (request()->custom_field[$i->name] == $p->value)? 'selected':'' }}>{{ $p->value }}</option>                                                            
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                        <div class="clearfix"></div>
                        <div class="col-xs-offset-9 col-md-offset-3">
                            <input type="submit" value="search" class="col-sm-8 btn btn-primary">
                        </div>
                    </div>
                </div>
            </form>
            @if ($products->count() > 0)
                @foreach ($products as $p)
                <div class="col-xs-12 col-md-4 homeProducts">
                    <a href="{{ route('product_index', ['id' => $p->id]) }}" style="text-decoration:none">
                        <img src="{{ uploads("productImg/" . $p->img) }}">
                        <a href="{{ url('wishlist/store/' . $p->id) }}" class="pull-right wishlistButton"><i class="wishlist {{ (in_array($p->id, $wishlistProductsIds))? 'fas fa-heart':'far fa-heart' }} fa-2x"></i></a>
                        <p class="brand">{{ $p->brandName }}</p>
                        <p class="name">{{ strtoupper($p->name) }}</p>
                        <p class="price">{{ number_format($p->price) }} EGP</p>
                        <form action="{{ route('api_cart_store') }}" method="POST" class="cart-form">
                            <input type="hidden" name="id" value="{{ $p->id }}">
                            <button type="submit" class="cartButton btn btn-success col-xs-12">
                                <i class="fas fa-shopping-cart fa-1x"></i> Buy Now
                            </button>
                        </form>
                    </a>
                </div>
                @endforeach
                <div class="clearfix"></div>
                <div class="text-center">
                    {{ $products->appends(request()->input())->links() }}
                </div>
            @else
                <div class="alert alert-danger">
                    <p class="text-center">Sorry, No products found!</p>
                </div>
            @endif
            <div class="clearfix"></div>
        </div>
@endsection