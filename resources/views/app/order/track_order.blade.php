@extends('layouts.app')
@section('content')
<div class="checkoutDone text-center">
    <h3>Track your order</h3>
    <form action="{{ url('orders/trackOrder') }}" method="POST" class="form-inline">
        {{ csrf_field() }}
        <div class="form-group">
            <div class="form-group mx-sm-3 mb-2">
                <label for="name" class="sr-only">Order Code</label>
                <input type="text" name="orderId" class="form-control" placeholder="Enter Order Code Here">
            </div>
        </div>
        <input type="submit" value="Enter" class="btn btn-info">
    </form>
    @if (isset($msg))
        <p style="color:red">{{ $msg }}</p>
    @endif
</div>
@endsection