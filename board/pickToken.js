/******************************************************
 *                ticketWindow funcs                  *
 ******************************************************               
*/

if (window.name=='Pick Customer')
{
    
//hint customer
    $(document).ready(function(){
        $("#assignee").keyup(function(){
            var surname=$("#assignee").val();
            $.post('hint.php',
                   {
                    searchCustomer:1,
                    surname:surname
                   },
                   function(data)
                   {
                    $("#hintsGot").html(data);
                   }
                    );
        });
    });

//copying surname,name
    $(document).ready(function(){
        $("#hintsGot").on('click','.customerHintSN',function(){
        var cust=$(this).html();
        window.opener.$("#tktCustomer").val(cust);
        window.close();
        });
    });

}


if(window.name=='Pick Asset')
{
//hint asset
    $(document).ready(function(){
        $("#asset").keyup(function(){
            var code=$(this).val();
            $.post('hint.php',
                   {
                   searchAsset:1,
                   code:code
                   },
                   function(data)
                   {
                    $("#hintsGot").html(data);
                   });
        });
    });

//copying asset code   
    $(document).ready(function(){
        $("#hintsGot").on('click','.assetHint',function(){
            var code=$(this).html();
            window.opener.$("#tktAsset").val(code);
            window.close();
        });
    });
}
/******************************************************
 *                assetWindow funcs                   *
 ******************************************************               
*/

if(window.name=='Pick Assignee')
{
//hint assignee
    $(document).ready(function(){
        $("#assignee").keyup(function(){
            var surname=$("#assignee").val();
            $.post('hint.php',
                   {
                    searchCustomer:1,
                    surname:surname
                   },
                   function(data)
                   {
                    $("#hintsGot").html(data);
                   }
                    );
        });
    });

//getting the ID from hint
    $(document).ready(function(){
        $("#hintsGot").on('click','.customerHint',function(){
            var custID=$(this).html();
            alert('You have selected ID'+ custID);
            window.opener.$("#assetAssignee").val(custID);
            window.close();
        });
    });
}


