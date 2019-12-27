@extends('admin.layouts.adminTemplate')
@section('content')
<h1 class="alert alert-info pageH">Sittings</h1>
<div class="col-xs-offset-2">
    @if (!isset($sittings))
    <form action="{{ aurl('sittings/create') }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="Email" class="col-xs-2 col-form-label">Email</label>
                <div class="col-xs-6">
                    <input type="text" name="email" class="form-control" placeholder="Email">
                </div>
            </div>
            <div class="form-group row">
                <label for="Facebook" class="col-xs-2 col-form-label">Facebook</label>
                <div class="col-xs-6">
                    <input type="text" name="fb" class="form-control" placeholder="Facebook">
                </div>
            </div>
            <div class="form-group row">
                <label for="Twitter" class="col-xs-2 col-form-label">Twitter</label>
                <div class="col-xs-6">
                    <input type="text" name="tw" class="form-control" placeholder="Twitter">
                </div>
            </div>
            <div class="form-group row">
                <label for="Youtube" class="col-xs-2 col-form-label">Youtube</label>
                <div class="col-xs-6">
                    <input type="text" name="yt" class="form-control" placeholder="Youtube">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-8">
                    <input type="submit" value="Set" class="btn btn-info pull-right">
                </div>
            </div>
        </form>
    @else
        <form action="{{ aurl("sittings/update/$sittings->id") }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="Email" class="col-xs-2 col-form-label">Email</label>
                <div class="col-xs-6">
                    <input type="text" name="email" class="form-control" placeholder="Email" value="{{ $sittings->email }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="Facebook" class="col-xs-2 col-form-label">Facebook</label>
                <div class="col-xs-6">
                    <input type="text" name="fb" class="form-control" placeholder="Facebook" value="{{ $sittings->fb }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="Twitter" class="col-xs-2 col-form-label">Twitter</label>
                <div class="col-xs-6">
                    <input type="text" name="tw" class="form-control" placeholder="Twitter" value="{{ $sittings->tw }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="Youtube" class="col-xs-2 col-form-label">Youtube</label>
                <div class="col-xs-6">
                    <input type="text" name="yt" class="form-control" placeholder="Youtube" value="{{ $sittings->yt }}">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-8">
                    <input type="submit" value="Update" class="btn btn-info pull-right">
                </div>
            </div>
        </form>
    @endif
    
</div>
@endsection