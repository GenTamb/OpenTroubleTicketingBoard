//disable all fields
$(document).ready(function(){
    if ($("#customerID").text()!='new')
    {
         $(".disabled").prop("disabled",true);    
    }
    else
    {
        $(".openedBy").prop("disabled",true);
        $(".solution").prop("disabled",true);
    }
});


//manage the edit button
$(document).ready(function(){
        var customerID=$("#customerID").text();
        var customerSurname=$("#customerSurname").val();
        var customerName=$("#customerName").val();
        var customerType=$("#customerType").val();
        var customerSite=$("#customerSite").val();
        var customerStatus=$("#customerStatus").val();
    $("#editCUST").on('click',function(){
        
    if($("#editCUST").text()=='Edit')
    {
        
        $(".editable").prop("disabled",false);
        $(".editable").addClass("activated");
        $(this).text('Save');
        
    }
    else
    {
        //acquiring datas
        
        var customerSurnamemod=$("#customerSurname").val();
        var customerNamemod=$("#customerName").val();
        var customerTypemod=$("#customerType").val();
        var customerSitemod=$("#customerSite").val();
        var customerStatusmod=$("#customerStatus").val();
        //posting data
        
        if(customerSurname!=customerSurnamemod ||customerName!=customerNamemod || customerType!=customerTypemod || customerSite!=customerTypemod || customerStatus!=customerStatusmod)
        {
            $.post('../configuration/job.php',
               {
                updateCUST:1,
                customerID:customerID,
                customerName:customerNamemod,
                customerSurname:customerSurnamemod,
                customerType:customerTypemod,
                customerSite:customerTypemod,
                customerStatus:customerStatusmod,
                
               },
               function(data)
               {
                alert(data);
               });
        }
        else alert('Customer was not modified');
        
        $(".editable").prop("disabled",true);
        $(".editable").removeClass("activated");
        $(this).text('Edit');
    }
    //closing on click
    });
});

//manage create button
$(document).ready(function(){
   $("#createCUST").click(function(){
    //acquire datas
    var customerSurname=$("#customerSurname").val();
    var customerName=$("#customerName").val();
    var customerType=$("#customerType").val();
    var customerSite=$("#customerSite").val();
    var customerStatus=$("#customerStatus").val();
    
    //checking inputs
    var token='';
    var go=true;
    switch (token)
    {
        case customerSurname:
                                alert('Customer\'s name is empty!');
                                go=false;
                                break;
        case customerName:
                                alert('Customer\'s surname is empty!');
                                go=false;
                                break;
        case customerType:
                                alert('Type is empty!');
                                go=false;
                                break;
        default:
                                go=true;
                                break;
    }
    //posting datas to create Customer
    if (go)
    {
        $.post('../configuration/job.php',
           {
            createCUSTOMER:1,
            customerSurname:customerSurname,
            customerName:customerName,
            customerType:customerType,
            customerSite:customerSite,
            customerStatus:customerStatus
           },
           function(data)
           {
            if (data[0]=='yes')
            {
                alert('Created Customer: '+data[1]);
                var custID=data[1];
                var url='customerWindow.php?id='+custID;
                var wName='Customer ID:'+custID;
                window.open(url,wName, 'width=800, height=360');
                window.close();
            }
            else alert(data[1]);
           },"json");
    }
   
   });
});



//close customer window
$(document).ready(function(){
    $("#closeCUST").click(function(){
        window.close();
    });
});