@extends('admin.layouts.adminTemplate')
@section('content')
<form action="{{ aurl('admins/deleteMultible') }}" method="POST">
        {{ csrf_field() }}
        <div class="alert alert-info pageH">
            <h1>Admins</h1>
            <a class="btn btn-primary col-xs-offset-10" href="{{ aurl('admins/create')}}">Create</a>
            <input type="submit" value="Delete" class="btn btn-danger">
        </div>
        <table class="table table-hover">
            <tr>
                <th><input id="allCheckbox" type="checkbox" value=""></th>
                <th>ID</th>
                <th>Name</th>
                <th>email</th>
                <th>Date</th>
                <th><small>edit | delete</small></th>
            </tr>
            @foreach ($allAdmins as $item)
                <tr>
                    <th><input class="singleCB" type="checkbox" name="id[]" value="{{ $item->id}}"></th>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                        <a href="{{ aurl('admins/edit')}}/{{ $item->id }}"><i class="fas fa-edit fa-lg editIcon"></i></a>
                        <a href="{{ aurl('admins/deleteSingle')}}/{{ $item->id }}"><i class="far fa-trash-alt fa-lg deleteIcon"></i></a>
                    </td>
                </tr>
            @endforeach
        </table>
    </form>
    {{ $allAdmins->links() }}
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