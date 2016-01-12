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

$(document).ready(function(){
    check_messages();
    setInterval(function(){ check_messages();}, 120000);
});

$(document).ready(function(){
    $("#searchTicket").click(function(e){
        e.preventDefault();
        var id=$("#searchTicket").val();
        if (isNaN(id))
        {
            alert(id+' in not a number');
        }
        else
        {
            $.post('configuration/job.php',
                   {
                    searchTKTbyID:1,
                    id:id
                   },
                   function(data)
                   {
                    var echoing;
                    if (data==0)
                    {
                        echoing='No tkt found with that id';
                    }
                    else
                    {
                        echoing=data;
                    }
                    $("#pageBody").html(echoing);
                    
                   });
        }
    });
});

function check_messages() {
    $.post('configuration/job.php',
           {
            checkMessages:1
           },
           function(data)
           {
            $("#counterMSG").html(data);
           }
          );
}


