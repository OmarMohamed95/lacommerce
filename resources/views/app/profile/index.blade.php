@extends('layouts.app')

@section('content')
<h3 class="text-center">{{ $user->name }}</h3>
<form action="{{ url('profile/update')}}"  method="POST" id="updateProfile">
    {{ csrf_field() }}
    <table class="wishlistTable table" style="background-color: white">
        <tr>
            <th>Name</th>
            <td class="editCred">
                <p class="col-xs-6">{{ $user->name }}</p>
            </td>
            <td>
                <div class="form-group row">
                    <div class="col-xs-6">
                        <input type="text" name="name" value="{{ $user->name }}" style="display:none" class="form-control profileInput" placeholder="Name">                        
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <th>Email</th>
            <td class="editCred">
                <p class="col-xs-6">{{ $user->email }}</p>
            </td>
            <td>
                <div class="form-group row">
                    <div class="col-xs-6">
                        <input type="text" name="email" value="{{ $user->email }}" style="display:none" class="form-control profileInput" placeholder="Email">                        
                    </div>
                </div>
            </td>
        </tr>           
        <tr>
            <th>Password</th>
            <td class="editCred">
                <p class="col-xs-6">**********</p>
            </td>
            <td>
                <div class="form-group row">
                    <div class="col-xs-6">
                        <input type="text" name="password" style="display:none" class="form-control profileInput" placeholder="Password">                        
                    </div>
                </div>
            </td>
        </tr>           
    </table>
    <a href="" class="col-xs-2 col-xs-offset-5 btn btn-primary editProfile"><i class="fas fa-edit fa-1x"></i> edit</a>
</form>
@endsection
@section('script')
@parent
    <script type="text/javascript">
        $(document).ready(function(){
            // edit profile
            $('.editProfile').on('click', function(e){
                e.preventDefault();

                $(this).fadeOut(function(){
                    $('#updateProfile').append(`<div class="form-group row">
                                                <div class="col-sm-12">
                                                    <input type="submit" value="submit" class="col-xs-2 col-xs-offset-5 btn btn-primary">
                                                </div>
                                            </div>`);
                });

                $(".editCred").fadeOut(function(){
                    $(".profileInput").fadeIn();
                });
                $(".editCred").children().fadeOut();
                $(this).remove();
            });
        });
    </script>
@endsection