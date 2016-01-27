/********************************************
 *                                          *
 *             draw asideLeft               *
 *                                          *
 ********************************************/
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

/********************************************
 *                                          *
 *       script control panel setup         *
 *                                          *
 ********************************************/
$(document).ready(function(){
    $("#pageBody").on('click','#sendRCgroup',function(event){
        event.preventDefault();
        var remoteGroupName=$("#remoteGroupName").val();
        if (remoteGroupName!='')
        {
         $.post('configuration/job.php',
                {
                    addingFirstGroupName:1,
                    remoteGroupName:remoteGroupName
                },
                function (data) {
                    if (data[0]=='yes') {
                        $("#rcNameForm").addClass('divHidden');
                        $("#createCustomersTable").removeClass('divHidden');
                    }
                    alert(data[1]);
                },
                "json");
        }
        else alert('Field is empty');
    });
});

$(document).ready(function(){
    $("#pageBody").on('click','#sendCTN',function(event){
        event.preventDefault();
        var CTN=$("#customersTableName").val();
        if (CTN!='')
        {
         $.post('configuration/job.php',
                {
                    addingCTN:1,
                    CTN:CTN
                },
                function (data) {
                    if (data[0]=='yes') {
                        $("#createCustomersTable").addClass('divHidden');
                        $("#finishSetup").removeClass('divHidden');
                    }
                    alert(data[1]);
                },
                "json");
        }
        else alert('Field is empty');
    });
});


$(document).ready(function(){
    $("#pageBody").on('click','#completeSetup',function(event){
         $.post('configuration/job.php',
                {
                    completeSetup:1
                },
                function (data) {
                    if (data[0]=='yes') {
                        window.open('login.php',"_top","fullscreen=1");
                        $("#finishSetup").addClass('divHidden');
                        $("#complete").removeClass('divHidden');
                        
                    }
                    alert(data[1]);
                    
                },
                "json");
        });
    });
/********************************************
 *                                          *
 *       script control panel funcs         *
 *                                          *
 ********************************************/

$(document).ready(function(){
    $("#pageBody").on('click',"#cpanelCategory",function(){
        window.open('board/cpanelCategory.php','Edit Categories',"width=350,height=600");
        
    });
});



/********************************************
 *                                          *
 *       draw control panel in pageBody     *
 *                                          *
 ********************************************/
$(document).ready(function(){
    $("#cpanelButton").click(function(){
        
        //pageUrl=$(this).attr('href');
        $.post("board/cpanel.php",
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


/********************************************
 *                                          *
 *          home board's functions          *
 *                                          *
 ********************************************/

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

//apply function check_personal_queue
$(document).ready(function(){
    check_personal_queue();
    setInterval(function(){ check_personal_queue();},100000);
});

//search ticket box
$(document).ready(function(){
    $("#searchTicket").click(function(e){
        e.preventDefault();
        var token=$("#ticketField").val();
        if (token=='')
        {
            alert('Field is empty');  
        }
        else
        {
            $.post('configuration/job.php',
                   {
                    searchTKTbyTOKEN:1,
                    token:token
                   },
                   function(data)
                   {
                    var echoing;
                    if (data==0)
                    {
                        echoing='No TKT found with that token';
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

//search customer box
$(document).ready(function(){
    $("#searchCustomer").click(function(e){
        e.preventDefault();
        var token=$("#customerField").val();
        if (token=='')
        {
            alert('Field is empty');  
        }
        else
        {
            $.post('configuration/job.php',
                   {
                    searchCUSTOMERbyTOKEN:1,
                    token:token
                   },
                   function(data)
                   {
                    var echoing;
                    if (data==0)
                    {
                        echoing='No Customer found with that token';
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

//search asset box
$(document).ready(function(){
    $("#searchAsset").click(function(e){
        e.preventDefault();
        var token=$("#assetField").val();
        if (token=='')
        {
            alert('Field is empty');  
        }
        else
        {
            $.post('configuration/job.php',
                   {
                    searchASSETbyTOKEN:1,
                    token:token
                   },
                   function(data)
                   {
                    var echoing;
                    if (data==0)
                    {
                        echoing='No Asset found with that token';
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
//open customer window
$(document).ready(function(){
           $('#pageBody').on('click','.CUSTOMERID', function()
           {
           var customerID=$(this).text();
           var url='board/windowCustomer.php?id='+customerID;
           var wName='Customer ID:'+customerID;
           window.open(url,wName, 'width=800, height=360');
           });
});

//open ticket window
$(document).ready(function(){
           $('#pageBody').on('click','.TKTID', function()
           {
           var tktID=$(this).text();
           var url='board/windowTicket.php?id='+tktID;
           var wName='Ticket ID:'+tktID;
           window.open(url,wName, 'width=800, height=360');
           });
});

//open asset window
$(document).ready(function(){
           $('#pageBody').on('click','.ASSETCODE', function()
           {
           var assetCODE=$(this).text();
           var url='board/windowAsset.php?id='+assetCODE;
           var wName='ASSET CODE:'+assetCODE;
           window.open(url,wName, 'width=800, height=360');
           });
});

//open new customer window
$(document).ready(function(){
    $("#customerNew").click(function(){
        var url='board/windowCustomer.php?new='+true;
        var wName='Creating New Customer';
        window.open(url,wName,'width=800, height=360');
        
    });
});

//open new ticket window
$(document).ready(function(){
    $("#tktNew").click(function(){
        var url='board/windowTicket.php?new='+true;
        var wName='Creating New Ticket';
        window.open(url,wName,'width=800, height=360');
        
    });
});

//open new asset window
$(document).ready(function(){
    $("#assetNew").click(function(){
        var url='board/windowAsset.php?new='+true;
        var wName='Creating New Asset';
        window.open(url,wName,'width=800, height=360');
        
    });
});

//open personal queue
$(document).ready(function(){
    $("#asideLeft").on('click','#personalQueue',function(){
        $.post('configuration/job.php',
               {
                listPersonalQueue:1
               },
               function(data)
               {
                $("#pageBody").html(data);
               });
      
    });
});



//enable tooltip
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    $('#asideLeft').on('mouseover','[data-toggle="tooltip"]',function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
});


//function check_personal_queue
function check_personal_queue(){
    $.post('configuration/job.php',
           {
            checkPQueue:1
           },
           function(data)
           {
            $("#personalQueueNumber").html(data);
           }
          );
}


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


