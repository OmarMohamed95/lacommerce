@extends('admin.layouts.adminTemplate')
@section('content')
<h1 class="alert alert-info pageH">Create brand</h1>
<div class="col-xs-offset-2">
    <form action="{{ aurl('brands') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group row">
            <label for="name" class="col-xs-2 col-form-label">Name</label>
            <div class="col-xs-6">
                <input type="text" name="name" class="form-control" placeholder="Name">
            </div>
        </div>
        <div class="form-group row">
            <label for="Image" class="col-xs-2 col-form-label">Image</label>
            <div class="col-xs-6">
                <input type="file" name="img" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xs-2 col-form-label" for="Category">Category</label>
            <div class="col-xs-6">
                <select name="category_id[]" class="form-control multipleSelect" multiple>
                    @foreach ($allcategories as $item)
                    @if (! in_array($item->id, $parentID))
                        <option value="{{ $item->id }}">{{ $item->name }}</option>                        
                    @endif
                    @endforeach
                </select>
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
@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        $('.multipleSelect').fastselect();
    });
</script>
@endsection