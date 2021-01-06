@extends('layouts.app')
@section('content')
<div class="checkoutDone text-center">
    <i class="far fa-check-circle fa-4x"></i>
    <h3 class="bold">your order is being prepared for shipping!</h3>
    <a href="{{ route('checkout_track_code', ['orderCode' => $orderCode]) }}" style="text-decoration: none">Track your Order</a>
</div>
@endsection