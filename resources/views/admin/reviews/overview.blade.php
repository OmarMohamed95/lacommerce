@extends('admin.layouts.adminTemplate')
@section('content')
    <h1>Overview</h1>
    <p>Review ID : {{ $single->id }}</p>
    <p>User ID : {{ $single->user_id }}</p>
    <div class="clearfix"></div>
    <p>Product ID : {{ $single->product_id }}</p>
    <hr>
    <p>Date : {{ $single->created_at }}</p>
    <p>Username : {{ $single->user->name }}</p>
    <p>{{ $single->content }}</p>
@endsection