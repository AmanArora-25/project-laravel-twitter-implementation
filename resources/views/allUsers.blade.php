@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-2">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><h4><strong>NAME</strong></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><h4><strong>ACTION</strong></h4></div>
        </div>
    </div>
    @foreach($allUsers as $user)
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">{{$user->name}}</div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><Button onclick="return followToggle({{$user->id}});" type="Button" class="btn btn-xs btn-primary" id="followButton{{$user->id}}">Follow</Button></div>
                {!! csrf_field() !!}
            </div>
        </div>
        <br/>
    @endforeach
    <center>{{$allUsers->links()}}</center>
    </div>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function followToggle(id){
        $.ajax({
            type: "POST",
            url: "{{url('newFollow')}}",
            data: "id="+id,
            success: function(html){
                alert(html);
                //$("#status").html(data);
            }
        }); 

    }
</script>
@endsection