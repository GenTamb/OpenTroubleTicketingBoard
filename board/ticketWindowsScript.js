//disable all fields
$(document).ready(function(){
    if ($("#tktID").text()!='new')
    {
         $(".disabled").prop("disabled",true);    
    }
    else
    {
        $(".openedBy").prop("disabled",true);
        $(".solution").prop("disabled",true);
    }
});
//disable 'time' fields
$(document).ready(function(){
    $(".time").prop("disabled",true);
});

//manage the edit button
$(document).ready(function(){
        var id=$("#tktID").text();
        var asset=$("#tktAsset").val();
        var category=$("#tktCategory").val();
        var status=$("#tktStatus").val();
        var assignedTo=$("#tktAssignedTo").val();
        var group=$("#tktGroup").val();
        var description=$("#tktDescription").val();
        var solution=$("#tktSolution").val();
    $("#editTKT").on('click',function(){
        
    if($("#editTKT").text()=='Edit')
    {
        if ($('#tktStatus').val()=='close') {
            alert('You cannot edit a closed tkt!');
        }
        else
        {
        $(".editable").prop("disabled",false);
        $(".editable").addClass("activated");
        $(this).text('Save');
        }
    }
    else
    {
        //acquiring datas
        var assetMOD=$("#tktAsset").val();
        var categoryMOD=$("#tktCategory").val();
        var statusMOD=$("#tktStatus").val();
        var assignedToMOD=$("#tktAssignedTo").val();
        var groupMOD=$("#tktGroup").val();
        //var closeTimeMOD=$("#tktCloseTime").val();
        var descriptionMOD=$("#tktDescription").val();
        var solutionMOD=$("#tktSolution").val();
        var closeTime;
        if (statusMOD!='close') closeTime='not closed yet'; 
        else closeTime=Date();
        var change='';
        //posting data
        
        if(asset!=assetMOD ||category!=categoryMOD ||status!=statusMOD || assignedTo!=assignedToMOD || group!=groupMOD || description!=descriptionMOD || solution!=solutionMOD)
        {
            $.post('../configuration/job.php',
               {
                updateTKT:1,
                id:id,
                asset:assetMOD,
                category:categoryMOD,
                status:statusMOD,
                assignedTo:assignedToMOD,
                group:groupMOD,
                closeTime:closeTime,
                description:descriptionMOD,
                solution:solutionMOD
               },
               function(data)
               {
                alert(data);
               });
            $("#tktCloseTime").val(closeTime);
        }
        else alert('Tkt was not modified');
        
        $(".editable").prop("disabled",true);
        $(".editable").removeClass("activated");
        $(this).text('Edit');
    }
    //closing on click
    });
});

//manage create button
$(document).ready(function(){
   $("#createTKT").click(function(){
    //acquire datas
    var tktCustomer=$("#tktCustomer").val();
    var asset=$("#tktAsset").val();
    var category=$("#tktCategory").val();
    var status=$("#tktStatus").val();
    var openedBy=$("#tktOpenedBy").val();
    var assignedTo=$("#tktAssignedTo").val();
    var group=$("#tktGroup").val();
    var description=$("#tktDescription").val();
    var openTime=Date();
   
    //splitting field in 2 variables
    var completeName=tktCustomer.split(',');
    var customerName=completeName[0];
    var customerSurname=completeName[1];
    
    //checking inputs
    var token='';
    var go=true;
    switch (token)
    {
        case customerName:
                                alert('Customer\'s name is empty!');
                                go=false;
                                break;
        case customerSurname:
                                alert('Customer\'s surname is empty!');
                                go=false;
                                break;
        case asset:
                                alert('Asset is empty!');
                                go=false;
                                break;
        case category:
                                alert('Category is empty!');
                                go=false;
                                break;
        case status:
                                alert('Status is empty!\nAre allowed only:\nOPEN,WORKING,PAUSE,CLOSE');
                                go=false;
                                break;
        case group:
                                alert('Group is empty!');
                                go=false;
                                break;
        case description:
                                alert('Description is empty!');
                                go=false;
                                break;
        default:
                                go=true;
                                break;
    }
    //posting datas to create Ticket
    if (go)
    {
        $.post('../configuration/job.php',
           {
            createTKT:1,
            asset:asset,
            category:category,
            status:status,
            customerName:customerName,
            customerSurname:customerSurname,
            openedBy:openedBy,
            assignedTo:assignedTo,
            group:group,
            openTime:openTime,
            description:description
           },
           function(data)
           {
            if (data[0]=='yes')
            {
                alert('Created Ticket: '+data[1]);
                var tktID=data[1];
                var url='ticketWindow.php?id='+tktID;
                var wName='Ticket ID:'+tktID;
                window.open(url,wName, 'width=800, height=360');
                window.close();
            }
            else alert(data[1]);
           },"json");
    }
   
   });
});

//update tkt
/*
$(document).ready(function(){
    $("#editTKT").click(function(){
    
        var asset=$("#tktAsset").val();
        var category=$("#tktCategory").val();
        var status=$("#tktStatus").val();
        var openedBy=$("#tktOpenedBy").val();
        var assignedTo=$("#tktAssignedTo").val();
        var group=$("#tktGroup").val();
        var closeTime=$("#tktCloseTime").val();
        var description=$("#tktDescription").val();
        var solution=$("#tktSolution").val();
        var closeTime;
        if (status=='closed') closeTime='not closed yet'; 
        else closeTime=Date();
        
        $.post('../configuration/job.php',
               {
                updateTKT:1,
                asset:asset,
                category:category,
                status:status,
                assignedTo:assignedTo,
                group:group,
                closeTime:closeTime,
                description:description,
                solution:solution
               },
               function(data)
               {
                //something
               }
              );
    });
});
*/
/*
 * function to check values
 */

//close ticket window
$(document).ready(function(){
    $("#closeTKT").click(function(){
        window.close();
    });
});