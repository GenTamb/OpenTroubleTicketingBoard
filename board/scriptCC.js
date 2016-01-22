$(document).ready(function(){
    $("#sendRCgroup").click(function(event){
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
    $("#sendCTN").click(function(event){
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
    $("#completeSetup").click(function(){
         $.post('configuration/job.php',
                {
                    completeSetup:1
                },
                function (data) {
                    if (data[0]=='yes') {
                        $("#finishSetup").addClass('divHidden');
                        $("#complete").removeClass('divHidden');
                        window.open('login.php',"_top","fullscreen=1");
                    }
                    alert(data[1]);
                    
                },
                "json");
        });
    });
