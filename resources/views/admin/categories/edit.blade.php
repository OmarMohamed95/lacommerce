@extends('admin.layouts.adminTemplate')
@section('content')
    <h1 class="alert alert-info pageH">Edit category</h1>
    <div class="col-xs-offset-2">
        <form action="{{ route('admin_category_update', ['categoryId' => $category->id] ) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-group row">
                <label for="name" class="col-xs-2 col-form-label">Name</label>
                <div class="col-xs-6">
                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $category->name }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xs-2 col-form-label" for="Parent">Parent section</label>
                <div class="col-xs-6">
                    <select name="parentID" class="form-control" id="parent_section">
                        <option @if ($category->parentID === null) selected @endif>none</option>
                        @foreach ($parentCategories as $parentCategory)
                            <option value="{{ $parentCategory->id }}" @if ($parentCategory->id == $category->parentID) selected @endif>{{ $parentCategory->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xs-2 col-form-label" for="Parent">Display in home</label>
                <div class="col-xs-6">
                    <input type="radio" name="home" value="1" {{ ($category->home == '1')? 'checked' : '' }} id="disable">home
                    <input type="radio" name="home" value="0" {{ ($category->home == '0')? 'checked' : '' }}>none
                    <div class="clearfix"></div>
                    <small style="color: red">Only child categories could be displayed in home page</small>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xs-2 col-form-label" for="Parent">Activity</label>
                <div class="col-xs-6">
                    <select name="status" class="form-control">
                        <option value="1" {{ ($category->status == '1') ? 'selected' : '' }}>activ</option>
                        <option value="0" {{ ($category->status == '0') ? 'selected' : '' }}>inactive</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="Sort" class="col-xs-2 col-form-label">Sort</label>
                <div class="col-xs-6">
                    <input type="number" name="sort" class="form-control" placeholder="Sort" value="{{ $category->sort }}">
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
            // disable display in home if the selected parent section is none
            parent_section();

            $('#parent_section').on('change', function(){
                parent_section();
            });

            function parent_section(){
                if($('#parent_section').val() === 'none'){
                    $('#disable').attr('disabled','disabled');
                }else{
                    $('#disable').attr('disabled',null);
                }
            }
        });
    </script>
@endsection