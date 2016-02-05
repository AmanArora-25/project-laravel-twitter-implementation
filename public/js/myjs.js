
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function followToggle(id){
        $.ajax({
            type: "POST",
            url: "http://localhost:8000/follow",
            data: "follow_user_id="+id,
            success: function(data){
                if(!data.status)
                    $('#'+id).html(data.message+"<button class=\"btn btn-primary btn-xs\" onclick=\"return unfollow("+id+");\">Unfollow</button>"); 
                else $('#'+id).html(data.message);
            }
        }); 
    }
    function unfollow(id){
        $.ajax({
            type: "POST",
            url: "http://localhost:8000/unfollow",
            data: "follow_user_id="+id,
            success: function(data){
                if(data.status)
                    $('#'+id).html(data.message); 
                else $('#'+id).html(data.message); 
            }
        }); 
    }
    function tweetNow(){
        var tweet = $('#tweetMessage').val();
        $.ajax({
            type: "POST",
            url: "http://localhost:8000/tweet/new",
            data: "message="+tweet,
            success:function(data){
                if(data.status){
                    $("#new_tweet").html(data.message);
                } else {
                    alert(data.message);
                }
            },
            error: function(exception){
               
            }
        }); 
    }
    function deleteTweet(id,user_id){
         $.ajax({
            type: "POST",
            url: "http://localhost:8000/tweet/delete",
            data: "id="+id,
            success:function(data){
                if(data.status){
                    document.getElementById("tweet_id_"+id).style.display="none";
                } else alert("couldn't delete");
            },
            
        }); 
    }
    $("#registrationForm").validate();
    $('#email').blur(function(){
        var email = $('#email').val();
        $.ajax({
            type: "POST",
            url: "http://localhost:8000/check_email",
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