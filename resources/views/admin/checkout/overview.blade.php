@extends('admin.layouts.adminTemplate')
@section('content')
    <h1>Overview</h1>
    <table class="table table-hover">
        <tr>
            <th>User ID</th>
            <td>{{ $single->first()->user_id }}</td>
        </tr>
        <tr>
            <th>Username</th>
            <td>{{ $single->first()->user->name }}</td>
        </tr>
        <tr>
            <th>Product ID</th>
            @foreach ($single as $i)
                <td>{{ $i->product_id }}</td>
            @endforeach
        </tr>
        <tr>
            <th>Quantity</th>
            @foreach ($single as $i)
                <td>{{ $i->quantity }}</td>
            @endforeach
        </tr>
        <tr>
            <th>Date</th>
            <td>{{ $single->first()->created_at }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>{{ $single->first()->address }}</td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>{{ $single->first()->phone }}</td>
        </tr>
    </table>
@endsection