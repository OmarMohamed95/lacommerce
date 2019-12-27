@extends('admin.layouts.adminTemplate')
@section('content')    
<form action="{{ aurl('custom_field/deleteMultible') }}" method="POST">
    {{ csrf_field() }}
    <div class="alert alert-info pageH">
        <h1>Custom Field</h1>
        <a class="btn btn-primary col-xs-offset-10" href="{{ aurl('custom_field/create')}}">Create</a>
        <input type="submit" value="Delete" class="btn btn-danger">
    </div>
    <table class="table table-hover">
            <tr>
                <th><input id="allCheckbox" type="checkbox" value=""></th>
                <th>ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Show in Filter</th>
                <th>Date</th>
                <th><small>edit | delete</small></th>
            </tr>
            @if (isset($allCustomField))
            @foreach ($allCustomField as $item)
            <tr>
                <th><input class="singleCB" type="checkbox" name="id[]" value="{{ $item->id}}"></th>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->type }}</td>
                <td>{{ ($item->show_in_filter === 0)? 'no':'yes'}}</td>
                <td>{{ $item->created_at }}</td>
                <td>
                    <a href="{{ aurl('custom_field')}}/{{ $item->id }}/edit"><i class="fas fa-edit fa-lg editIcon"></i></a>
                    <a href="{{ aurl('custom_field/deleteSingle')}}/{{ $item->id }}"><i class="far fa-trash-alt fa-lg deleteIcon"></i></a>
                </td>
                </tr>
                @endforeach
            @else
                <p>No custom fields found!</p>
            @endif
        </table>
    </form>
    {{ $allCustomField->links() }}
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