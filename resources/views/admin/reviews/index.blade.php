@extends('admin.layouts.adminTemplate')
@section('content')
<form action="{{ aurl('reviews/deleteMultible') }}" method="POST">
        {{ csrf_field() }}
        <div class="alert alert-info pageH">
            <h1>Reviews</h1>
            <input type="submit" value="Delete" class="btn btn-danger">
        </div>
        <table class="table table-hover">
            <tr>
                <th><input id="allCheckbox" type="checkbox" value=""></th>
                <th>ID</th>
                <th>Username</th>
                <th>product Name</th>
                <th>review</th>
                <th>Date</th>
                <th>Overview</th>
                <th><small>delete</small></th>
            </tr>
        @if ($all)    
            @foreach ($all as $item)
            <tr>
                <th><input class="singleCB" type="checkbox" name="id[]" value="{{$item->id}}"></th>
                <td>{{$item->id}}</td>
                <td>{{$item->user->name}}</td>
                <td>{{$item->product->name}}</td>
                <td>{{$item->content}}</td>
                <td>{{$item->created_at}}</td>
                <td><a href="{{ aurl("reviews/overview/$item->id")}}" class="btn btn-success">overview</a></td>
                <td>
                        <a href="{{ aurl("reviews/deleteSingle/$item->id")}}"><i class="far fa-trash-alt fa-lg deleteIcon"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
        </table>
    </form>
    {{ $all->links() }}
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