@extends('admin.layouts.adminTemplate')
@section('content')
<form action="{{ aurl('categories/deleteMultible') }}" method="POST">
        {{ csrf_field() }}
        <div class="alert alert-info pageH">
            <h1>Categories</h1>
            <a class="btn btn-primary col-xs-offset-10" href="{{ aurl('categories/create')}}">Create</a>
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
            @foreach ($allCategories as $item)
                <tr>
                    <th><input class="singleCB" type="checkbox" name="id[]" value="{{ $item->id}}"></th>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ ($item->parentID === NULL)? 'no parent' : $item->parent->name }}</td>
                    <td>{{ ($item->status === 0)? 'inactiv' : 'activ' }}</td>
                    <td>{{ $item->Admin->name }}</td>
                    <td>{{ ($item->home === 0)? 'none':'home'}}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->sort }}</td>
                    <td>
                        <a href="{{ aurl('categories')}}/{{ $item->id }}/edit"><i class="fas fa-edit fa-lg editIcon"></i></a>
                        <a href="{{ aurl('categories/deleteSingle')}}/{{ $item->id }}"><i class="far fa-trash-alt fa-lg deleteIcon"></i></a>
                    </td>
                </tr>
            @endforeach
        </table>
    </form>
    {{ $allCategories->links() }}
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