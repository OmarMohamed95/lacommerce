@extends('layouts.app')
@section('content')
        <div class="homeProductsContainer">
            <h3>{{ strtoupper($category->name) }}</h3>
            <p style="color: grey; text-align: center;">{{ $products->count() }} products found</p>
            <hr>
            <form action="{{ url('category/tools/' . $category->id) }}" method="get" id="toolsForm">
                {{ csrf_field() }}
                <div class="form-group row toolsWrap">
                    <div class="col-xs-offset-1 col-xs-10">
                        <div class="col-xs-6 col-md-2 tool">
                            <input type="number" name="min" class="form-control" placeholder="Min" value="{{ request()->min }}">
                        </div>
                        <div class="col-xs-6 col-md-2 tool">
                            <input type="number" name="max" class="form-control" placeholder="Max" value="{{ request()->max }}">
                        </div>
                        <div class="col-xs-6 col-md-2 tool">
                            <select name="sortBy" class="form-control tools">
                                <option value="" hidden selected>Sort By</option>
                                <option value="created_at/desc" {{ (request()->sortBy == "created_at/desc")? 'selected':'' }}>Newest</option>                        
                                <option value="created_at/asc" {{ (request()->sortBy == "created_at/asc")? 'selected':'' }}>Oldest</option>                        
                                <option value="price/asc" {{ (request()->sortBy == "price/asc")? 'selected':'' }}>Lowest Price</option>                        
                                <option value="price/desc" {{ (request()->sortBy == "price/desc")? 'selected':'' }}>Highest Price</option>                        
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
                                @if ($i->custom_field->count() > 0)    
                                    <div class="col-xs-6 col-md-2 tool">
                                        <select name="cf[{{$k}}]" class="form-control tools">
                                            <option value="" hidden selected>{{$i->custom_field->first()->name}}</option>
                                            @foreach ($i->custom_field_product->unique('value') as $p)
                                            <option value="{{ $p->value }}" {{ (request()->cf[$k] == $p->value)? 'selected':'' }}>{{ $p->value }}</option>                                                            
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
                    <img src="{{ uploads("productImg/" . $p->img) }}">
                    <a href="{{ url('wishlist/store/' . $p->id) }}" class="pull-right wishlistButton"><i class="wishlist {{ (in_array($p->id, $wishlistProductsIds))? 'fas fa-heart':'far fa-heart' }} fa-2x"></i></a>
                    <p class="brand">{{ $p->brandName }}</p>
                    <a href="{{ url('product/index/' . $p->id) }}" style="text-decoration:none">
                        <p class="name">{{ strtoupper($p->name) }}</p>
                    </a>
                        <p class="price">{{ $p->price }} EGP</p>
                    <a href="{{ url('cart/store/' . $p->id) }}" class="cartButton btn btn-success col-xs-12"><i class="fas fa-shopping-cart fa-1x"></i> Buy Now</a>
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