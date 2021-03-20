@extends('admin.layouts.adminTemplate')
@section('content')
    <h1 class="alert alert-info pageH">Edit admin</h1>
    <div class="col-xs-offset-2">
        <form action="{{ aurl('admins/update/' . $single->id ) }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="Name" class="col-xs-2 col-form-label">Name</label>
                <div class="col-xs-6">
                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $single->name }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="Email" class="col-xs-2 col-form-label">Email</label>
                <div class="col-xs-6">
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ $single->email }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="Password" class="col-xs-2 col-form-label">Password</label>
                <div class="col-xs-6">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-8">
                    <input type="submit" value="submit" class="btn btn-info pull-right">
                </div>
            </div>
        </form>
    </div>
@endsection