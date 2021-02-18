@extends('admin.layouts.adminTemplate')
@section('content')
<form action="{{ route('admin_category_delete') }}" method="POST">
        {{ csrf_field() }}
        <div class="alert alert-info pageH">
            <h1>Categories</h1>
            <a class="btn btn-primary col-xs-offset-10" href="{{ route('admin_category_create')}}">Create</a>
            <input type="submit" value="Delete" class="btn btn-danger">
        </div>
        <table class="table table-hover">
            <tr>
                <th><input id="allCheckbox" type="checkbox" value=""></th>
                <th>ID</th>
                <th>Name</th>
                <th>Parent</th>
                <th>Status</th>
                <th>Creator</th>
                <th>Home</th>
                <th>Date</th>
                <th>Sort</th>
                <th><small>edit | delete</small></th>
            </tr>
            @foreach ($categories as $category)
                <tr>
                    <th><input class="singleCB" type="checkbox" name="id[]" value="{{ $category->id}}"></th>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ ($category->parentID === NULL)? 'no parent' : $category->parent->name }}</td>
                    <td>{{ ($category->status === 0)? 'inactiv' : 'activ' }}</td>
                    <td>{{ $category->Admin->name }}</td>
                    <td>{{ ($category->home === 0)? 'none':'home'}}</td>
                    <td>{{ $category->created_at }}</td>
                    <td>{{ $category->sort }}</td>
                    <td>
                        <a href="{{ route('admin_category_edit', ['categoryId' => $category->id]) }}"><i class="fas fa-edit fa-lg editIcon"></i></a>
                        <a href="{{ route('admin_category_delete', ['categoryId' => $category->id]) }}"><i class="far fa-trash-alt fa-lg deleteIcon"></i></a>
                    </td>
                </tr>
            @endforeach
        </table>
    </form>
    {{ $categories->links() }}
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        $('#allCheckbox').on('change', function(){
            $(".singleCB").prop('checked', this.checked);
        });
    });
</script>
@endsection