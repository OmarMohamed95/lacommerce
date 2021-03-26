@extends('admin.layouts.adminTemplate')
@section('content')
@inject('orderStates', 'App\Constants\OrderStatus')

<form action="{{ route("admin_order_multiple_state") }}" method="POST">
        {{ csrf_field() }}
        <div class="alert alert-info pageH">
            <h1>Orders</h1>
            <button type="submit" name="multipleStatus" value="{{ $orderStates::PREPARING }}" class="btn btn-primary">Preparing</button>
            <button type="submit" name="multipleStatus" value="{{ $orderStates::SHIPPED }}" class="btn btn-primary">Shipped</button>
            <button type="submit" name="multipleStatus" value="{{ $orderStates::DELIVERED }}" class="btn btn-primary">Delivered</button>
        </div>
        <table class="table table-hover">
            <tr>
                <th><input id="allCheckbox" type="checkbox" value=""></th>
                <th>ID</th>
                <th>phone</th>
                <th>address</th>
                <th>Date</th>
                <th>status</th>
                <th><small>overview</small></th>
            </tr>
            @if ($orders)
            @foreach ($orders as $order)
                <tr>
                    <th><input class="singleCB" type="checkbox" name="orderIds[]" value="{{$order->id}}"></th>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>{{ $order->address }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>
                        <select name="status" class="state_single" data-url="{{ route('api_order_update_status', ['order' => $order->id]) }}">
                            <option value="{{ $orderStates::PREPARING }}" {{ ($order->status == $orderStates::PREPARING) ? 'selected' : '' }}>Preparing</option>
                            <option value="{{ $orderStates::SHIPPED }}" {{ ($order->status == $orderStates::SHIPPED) ? 'selected' : '' }}>Shipped</option>
                            <option value="{{ $orderStates::DELIVERED }}" {{ ($order->status == $orderStates::DELIVERED) ? 'selected' : '' }}>Delivered</option>
                        </select>
                    </td>
                    <td><a href="{{ route("admin_order_overview", ['orderId' => $order->id])}}" class="btn btn-success">overview</a></td>
                </tr>
            @endforeach
            @endif
        </table>
    </form>
    <div class="pull-right">
        {{$orders->links()}}
    </div>
@endsection
@section('script')
    @parent
    <script src="{{ mix('js/Admin/order.js') }}" type="text/javascript"></script>
@endsection