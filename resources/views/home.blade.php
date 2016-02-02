@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <form class="jumbotron" name="newTweet" method="POST">
                {{ csrf_field() }}
                    <input type="text" class="form-control" id="tweetMessage" name="tweetMessage" autocomplete="off" placeholder="Enter a new Tweet..."/>
                    <br/>
                    <input class="btn btn-primary" id ="submitTweet" type="submit" value ="submit Tweet" onclick="return tweetNow();" />
            </form>
            @foreach($tweets as $tweet)
            <div class="row comment">
                <div class="col-sm-2">
                    <img src="images/avatars/7.jpg" class="avatar img-responsive" />
                </div>
                <div class="col-sm-10">
                    <div class="message clearfix">
                        <header>
                            <span class="name"><strong>{{$tweet['name']}}</strong></span>
                        </header>
                        <div class="note">
                            {{$tweet['message']}}
                        </div>
                    </div>
                </div>
            </div>
            <br/>
            @endforeach
        </div>
    </div>
</div>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function tweetNow(){
        var tweet = $('#tweetMessage').val();
        $.ajax({
            type: "POST",
            url: "{{url('newTweet')}}",
            data: "tweetMessage="+tweet,
            success:function(html){
            }
        }); 
    }
</script>
@endsection
