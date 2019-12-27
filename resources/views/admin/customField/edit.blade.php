@extends('admin.layouts.adminTemplate')
@section('content')
    <h1 class="alert alert-info pageH">Edit custom field</h1>
    <div class="col-xs-offset-2">
        <form action="{{ aurl('custom_field/' . $single->id ) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-group row">
                <label for="name" class="col-xs-2 col-form-label">Name</label>
                <div class="col-xs-6">
                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $single->name }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xs-2 col-form-label" for="type">Type</label>
                <div class="col-xs-6">
                    <select name="type" class="form-control">
                        @if ($single->type === 'text')
                            <option value="text" selected>text</option>
                            <option value="number">number</option>
                        @elseif ($single->type === 'number')
                            <option value="text">text</option>
                            <option value="number" selected>number</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xs-2 col-form-label" for="show_in_filter">Show in Filter</label>
                <div class="col-xs-6">
                    <input type="radio" name="show_in_filter" value="1" {{ ($single->show_in_filter == '1')? 'checked' : '' }}>yes
                    <input type="radio" name="show_in_filter" value="0" {{ ($single->show_in_filter == '0')? 'checked' : '' }}>no
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xs-2 col-form-label" for="Category">Category</label>
                <div class="col-xs-6">
                    <select name="category_id[]" class="form-control multipleSelect" multiple>
                        @foreach ($allcategories as $item)
                        @if (! in_array($item->id, $parentID))
                            <option value="{{ $item->id }}" {{ (in_array($item->id, $cf_cate)) ? 'selected':'' }}>{{ $item->name }}</option>                        
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
    <script type="text/javascript">
        $(document).ready(function(){
            $('.multipleSelect').fastselect();
        });
    </script>
@endsection