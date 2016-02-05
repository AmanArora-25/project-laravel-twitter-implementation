@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <form class="jumbotron" name="newTweet" method="POST">
                {{ csrf_field() }}
                    <input type="text" class="form-control" id="tweetMessage" name="tweetMessage" autocomplete="off" placeholder="Enter a new Tweet..."/>
                    <br/>
                    <button class="btn btn-primary" id ="submitTweet" onclick="return tweetNow();" >Submit Tweet</button> 
            </form>
            <div id="new_tweet"></div>
            @foreach($tweets as $tweet)
            <div class="row" id = "tweet_id_{{$tweet->id}}">
                <div class="col-sm-2">
                    <img src="{{url('images/profile/')}}/{{$tweet->user->id}}" class="avatar img-responsive" />
                </div>
                <div class="col-sm-10">
                    <div class="message clearfix">
                        <header>
                            <span class="name"><strong>{{$tweet->user->name}}</strong></span>
                            <button class="glyphicon glyphicon-remove pull-right" onclick="return deleteTweet({{$tweet->id}})"></button>
                        </header>
                        <div class="note">
                            {{$tweet->message}}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
