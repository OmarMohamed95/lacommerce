@extends('emails.base.base')
@section('content')
    @inject('orderStates', 'App\Constants\OrderStatus')
    <h1 style="font-weight: bold;">Lacommerce</h1>
    <table>
        <tr>
            <td style="color:green;">
                <p>The status of your order #{{ $order->id }} is <span style="color: red">{{ $orderStatusLabel }}</p>
            </td>
        </tr>
        <tr>
            <td style="">
                <a href="{{ route('order_track', ['orderId' => $order->id]) }}">Track your order</a>
            </td>
        </tr>
    </table>
@endsection