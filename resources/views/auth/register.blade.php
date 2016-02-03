@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" name="registrationForm" role="form" method="POST" action="{{ url('/register') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? '' : '' }}">
                            <label class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" required>
                                <span id="email_exists" class="text-warning"></span>
                                @if ($errors->has('email'))
                                    <span class="help-block" id="invalidEmail">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" id="password" name="password" required>
                                <span id="password_min_length" class="text-warning"></span>
                                @if ($errors->has('password'))
                                    <span class="help-block" id="invalidPassword">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation" minlength ="6" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
    $("#registrationForm").validate();
    $('#email').blur(function(){
        var email = $('#email').val();
        $.ajax({
            type: "POST",
            url: "{{url('checkEmail')}}",
            data: "email="+email,
            success: function(html){
                if(html=="true"){
                    $('#email_exists').html("Email Id Exists. please <a href={{ url('/login') }}> login"); 
                    $('#invalidEmail').html(""); 
                }else if(html=="false"){
                    $('#email_exists').html("");
                    $('#invalidEmail').html("");
                }
                //$("#status").html(data);
            }
        });
    });
    $('#password').blur(function(){
        var password = $('#password').val();
        if(password.length<6){
            $('#password_min_length').html("Password must have atleast 6 characters"); 
            $('#invalidPassword').html(""); 
        } else {
            $('#password_min_length').html("");
            $('#invalidPassword').html("");
        }
    });
</script>
@endsection
