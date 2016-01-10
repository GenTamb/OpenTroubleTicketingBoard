$(document).ready(function(){
    $("#send").click(function(event){
        event.preventDefault();
        var username=$("#username").val();
        var password=$("#password").val();
        if (username=="" || password=="")
           {
            alert('One or more fields are empty!\nRetry');
           }
        else
        {
            $.post('configuration/job.php',
                {
                    login:1,
                    username:username,
                    password:password
                },
                function (data)
                {
                 if(data[0])
                 {
                    alert('Welcome '+data[1]+' '+data[2]);
                    window.location.replace('board.php');
                 }
                 else alert(username+' we don\'t know you');
                },
                "json"
            );
        }
    });
});