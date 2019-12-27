@extends('admin.layouts.loginTemplate')
@section('content')
    <form method="POST" action="{{ route('admin.login.submit') }}">
        {{ csrf_field() }}
        <label for="email">Email</label>
        <input type="email" name="email">
        <label for="password">Password</label>
        <input type="password" name="password">
        <input type="submit">
    </form>
@endsection