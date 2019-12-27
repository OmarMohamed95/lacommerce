@extends('layouts.app')
@section('content')
<div class="checkoutDone text-center">
    <i class="far fa-check-circle fa-4x"></i>
    <h3 class="bold">your order is being prepared for shipping!</h3>
    <a href="{{ url("checkout/track/$order_code") }}" style="text-decoration: none">Track your Order</a>
</div>
@endsection