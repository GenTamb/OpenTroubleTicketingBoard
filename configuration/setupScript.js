$(document).ready(function(){
    $("#send1").click(function(event){
        event.preventDefault();
        var dbName=$("#dbName").val();
        var host=$("#host").val();
        var user=$("#user").val();
        var psw=$("#psw").val();
        if (/^[0-9.@_-]/.test(dbName) || /#/.test(dbName))
        {
            alert("DB's Name cannot start with 0-9 or .@_-\nor contain #");
        }
        else
        {
        if (dbName=="" || host=="" || user=="")
        {
            alert("All/some fields are empty!\nFill them!");
        }
        else
        {
            $.post("configuration/job.php",
                   {
                    configureDB: 1,
                    dbName:dbName,
                    host:host,
                    user:user,
                    psw:psw
                   },
                   function(data)
                   {
                     
                     if(data[0]=='yes')
                     {
                        $("#setupDBform").addClass("divHidden");
                        $("#setupAdminform").removeClass("divHidden");
                     }
                     alert(data[1]);
                   },
                   "json"
                   );
        }
        }
    }); 
});

$(document).ready(function(){
    $("#send2").click(function(event){
        event.preventDefault();
        var adminUserName=$("#adminUserName").val();
        var adminName=$("#adminName").val();
        var adminSurName=$("#adminSurName").val();
        var adminPassword=$("#adminPassword").val();
        if (adminUserName=="" || adminPassword=="")
        {
            alert("UserName and\or Password fields are empty!\nFill them!");
        }
        else
        {
            $.post("configuration/job.php",
                   {
                    configureAdmin: 1,
                    adminUserName:adminUserName,
                    adminName:adminName,
                    adminSurName:adminSurName,
                    adminPassword:adminPassword
                   },
                   function(data)
                   {
                     
                     if(data[0]=='yes')
                     {
                        $("#setupAdminform").addClass("divHidden");
                        $("#setupBoardForm").removeClass("divHidden");
                     }
                     alert(data[1]);
                   },
                   "json"
                   );
        }
    }); 
});

$(document).ready(function(){
    $("#send3").click(function(event){
        event.preventDefault();
        var boardName=$("#boardName").val();
        var organizationName=$("#organizationName").val();
        if (boardName=="")
        {
            alert("At least, board's name should not be empty!\nFill it!");
        }
        else
        {
            $.post("configuration/job.php",
                   {
                    configureBoard: 1,
                    boardName:boardName,
                    organizationName:organizationName,
                   },
                   function(data)
                   {
                     
                     if(data[0]=='yes')
                     {
                        $("#setupBoardForm").addClass("divHidden");
                        //$("#setupBoardForm").removeClass("divHidden");
                     }
                     alert(data[1]);
                   },
                   "json"
                   );
        }
    }); 
});