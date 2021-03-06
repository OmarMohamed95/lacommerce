@extends('admin.layouts.adminTemplate')
@section('content')
<form action="{{ aurl('products/deleteMultible') }}" method="POST">
        {{ csrf_field() }}
        <div class="alert alert-info pageH">
            <h1>Products</h1>
            <a class="btn btn-primary col-xs-offset-10" href="{{ aurl('products/create')}}">Create</a>
            <input type="submit" value="Delete" class="btn btn-danger">
        </div>
        <table class="table table-hover">
            <tr>
                <th><input id="allCheckbox" type="checkbox" value=""></th>
                <th>ID</th>
                <th>Name</th>
                <th>category</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>brand</th>
                <th>Date</th>
                <th>Preview</th>
                <th><small>edit | delete</small></th>
            </tr>
            @foreach ($allProducts as $item)
                <tr>
                    <th><input class="singleCB" type="checkbox" name="id[]" value="{{ $item->id}}"></th>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category->name ?? '' }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->brand->name ?? '' }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td><a href="{{ aurl('products')}}/{{ $item->id }}" class="btn btn-success">preview</a></td>
                    <td>
                        <a href="{{ aurl('products')}}/{{ $item->id }}/edit"><i class="fas fa-edit fa-lg editIcon"></i></a>
                        <a href="{{ aurl('products/deleteSingle')}}/{{ $item->id }}"><i class="far fa-trash-alt fa-lg deleteIcon"></i></a>
                    </td>
                </tr>
            @endforeach
        </table>
    </form>
    {{ $allProducts->links() }}
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