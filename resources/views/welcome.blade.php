@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    Welcome to Twitter!!
                    <p>Please <a href="{{ url('/login') }}">Login</a> or <a href="{{ url('/register') }}">Register</a> to Continue</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
