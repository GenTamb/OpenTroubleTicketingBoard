//draw asideLeft
$(document).ready(function(){
    $.post("board/sideLeft.php",
           {
            set:1
           },
           function(data)
           {
            $("#asideLeft").html(data);
           }
          );
});

//draw control panel in pageBody
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

//logout function
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

//apply function check_messages
$(document).ready(function(){
    check_messages();
    setInterval(function(){ check_messages();}, 120000);
});

//search ticket box
$(document).ready(function(){
    $("#searchTicket").click(function(e){
        e.preventDefault();
        var id=$("#ticketField").val();
        if (id=='')
        {
            alert('Field is empty');  
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

//open ticket window
$(document).ready(function(){
           $('#pageBody').on('click','.TKTID', function()
           {
           var tktID=$(this).text();
           var url='board/ticketWindow.php?id='+tktID;
           var wName='Ticket ID:'+tktID;
           window.open(url,wName, 'width=800, height=360');
           });
});

//open new ticket window
$(document).ready(function(){
    $("#tktNew").click(function(){
        var url='board/ticketWindow.php?new='+true;
        var wName='Creating New Ticket';
        window.open(url,wName,'width=800, height=360');
        
    });
});






//enable tooltip
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});

//function check_messages
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


