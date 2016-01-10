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
                        alert(data[1]);
                        $("#rcNameForm").addClass('divHidden');
                        //$("#setupCustomersTable").removeClass('divHidden');
                    }
                },
                "json");
        }
        else alert('Field is empty');
    });
});