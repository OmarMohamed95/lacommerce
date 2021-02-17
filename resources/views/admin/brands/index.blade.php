@extends('admin.layouts.adminTemplate')
@section('content')
<form action="{{ route('admin_brand_delete') }}" method="POST">
        {{ csrf_field() }}
        <div class="alert alert-info pageH">
            <h1>Brands</h1>
            <a class="btn btn-primary col-xs-offset-10" href="{{ route('admin_brand_create')}}">Create</a>
            <input type="submit" value="Delete" class="btn btn-danger">
        </div>
        <table class="table table-hover">
            <tr>
                <th><input id="allCheckbox" type="checkbox" value=""></th>
                <th>ID</th>
                <th>Name</th>
                <th>category</th>
                <th>Image</th>
                <th>Date</th>
                <th><small>edit | delete</small></th>
            </tr>
            @foreach ($brands as $brand)
                <tr>
                    <th><input class="singleCB" type="checkbox" name="id[]" value="{{ $brand->id}}"></th>
                    <td>{{ $brand->id }}</td>
                    <td>{{ $brand->name }}</td>
                    <td>
                        <ul>
                            @foreach ($brand->category as $category)
                                <li>{{ $category->name }}</li>
                            @endforeach
                        </ul>    
                    </td>
                    <td><img src="{{ url("/uploads/brandImg/$brand->img") }}" class='showEditImg'></td>
                    <td>{{ $brand->created_at }}</td>
                    <td>
                        <a href="{{ route('admin_brand_edit', ['brandId' => $brand->id]) }}"><i class="fas fa-edit fa-lg editIcon"></i></a>
                        <a href="{{ route('admin_brand_delete', ['brandId' => $brand->id]) }}"><i class="far fa-trash-alt fa-lg deleteIcon"></i></a>
                    </td>
                </tr>
            @endforeach
        </table>
    </form>
    {{ $brands->links() }}
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