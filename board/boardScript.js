$(document).ready(function(){
    $("#controlPanelButton").click(function(){
        
        //pageUrl=$(this).attr('href');
        $.post("board/controlPanel.php",
               { set: 1
               },
               function(data)
               {
                $("#pageBody").html(data);
               }
              );
        /*if(pageUrl!=window.location)
        {
        window.history.pushState({path:pageUrl},'',pageUrl);
        }
        return false;*/
    });
});

$(document).ready(function(){
    $("#logout").click(function(){
        $.post('board/logout.php',
               {
                logout:1
               },
               function(data)
               {
                alert(data[1]);
                window.location.replace('login.php');
               },
               "json");
    });
});


