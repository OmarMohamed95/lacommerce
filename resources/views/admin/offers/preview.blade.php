@extends('admin.layouts.adminTemplate')
@section('content')
    <h1>{{ $single->name }}</h1>
    <small class="">price : {{ $single->price }}</small>
    <div class="clearfix"></div>
    <p style="display: inline;">{{ $single->brand->name }}</p>
    <img class="preivewBrandImg" src="{{ url("/uploads/brandImg/" . $single->brand->img) }}">
    <div class="clearfix"></div>
    <hr>
    @foreach ($productImg as $item)
        <img class="preivewProductImg" src="{{ url("/uploads/productImg/" . $item->img) }}">
    @endforeach
    <hr>
    <p>{{ $single->desc }}</p>
@endsection