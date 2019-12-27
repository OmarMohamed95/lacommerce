@extends('admin.layouts.adminTemplate')
@section('content')
<form action="{{ aurl("checkout/state_multible") }}" method="POST">
        {{ csrf_field() }}
        <div class="alert alert-info pageH">
            <h1>Checkouts</h1>
            <input type="submit" name="state_button" value="preparing" class="btn btn-primary">
            <input type="submit" name="state_button" value="shipped" class="btn btn-primary">
            <input type="submit" name="state_button" value="delivered" class="btn btn-primary">
        </div>
        <table class="table table-hover">
            <tr>
                <th><input id="allCheckbox" type="checkbox" value=""></th>
                <th>ID</th>
                <th>Order Code</th>
                <th>Date</th>
                <th>state</th>
                <th><small>overview</small></th>
            </tr>
            @if ($all)
            @foreach ($all->unique('order_code') as $item)
                <tr>
                    <th><input class="singleCB" type="checkbox" name="order_code[]" value="{{$item->order_code}}"></th>
                    <td>{{$item->id}}</td>
                    <td>{{$item->order_code}}</td>
                    <td>{{$item->created_at}}</td>
                    <td>
                        <select name="state" class="state_single" role="{{$item->order_code}}">
                            <option value="preparing" {{($item->state === 'preparing')? 'selected':''}}>Preparing</option>
                            <option value="shipped" {{($item->state === 'shipped')? 'selected':''}}>Shipped</option>
                            <option value="delivered" {{($item->state === 'delivered')? 'selected':''}}>Delivered</option>
                        </select>
                    </td>
                    <td><a href="{{ aurl("checkout/overview/$item->order_code")}}" class="btn btn-success">overview</a></td>
                </tr>
            @endforeach
            @endif
        </table>
    </form>
    <div class="pull-right">
        {{$all->links()}}
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            // check all
            $('#allCheckbox').on('change', function(){
                $(".singleCB").prop('checked', this.checked);
            });

            //update state of single order
            $('.state_single').on('change', function(){

                var order_code = $(this).attr('role')
                var url = `{{aurl('checkout/state_single/${order_code}')}}`
                var data = $(this).val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: url,
                    data: {state: data},
                    method: 'POST',
                    success: function(data){
                        
                    },
                });
            });
        });
    </script>
@endsection