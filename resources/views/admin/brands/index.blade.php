@extends('admin.layouts.adminTemplate')
@section('content')
<form action="{{ aurl('brands/deleteMultible') }}" method="POST">
        {{ csrf_field() }}
        <div class="alert alert-info pageH">
            <h1>Brands</h1>
            <a class="btn btn-primary col-xs-offset-10" href="{{ aurl('brands/create')}}">Create</a>
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
            @foreach ($allBrands as $item)
                <tr>
                    <th><input class="singleCB" type="checkbox" name="id[]" value="{{ $item->id}}"></th>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>
                        <ul>
                            @foreach ($item->category as $c)
                                <li>{{ $c->name }}</li>
                            @endforeach
                        </ul>    
                    </td>
                    <td><img src="{{ url("/uploads/brandImg/$item->img") }}" class='showEditImg'></td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                        <a href="{{ aurl('brands')}}/{{ $item->id }}/edit"><i class="fas fa-edit fa-lg editIcon"></i></a>
                        <a href="{{ aurl('brands/deleteSingle')}}/{{ $item->id }}"><i class="far fa-trash-alt fa-lg deleteIcon"></i></a>
                    </td>
                </tr>
            @endforeach
        </table>
    </form>
    {{ $allBrands->links() }}
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