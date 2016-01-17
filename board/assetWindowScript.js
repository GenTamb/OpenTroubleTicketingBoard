//disable all fields
$(document).ready(function(){
    if ($("#assetCODE").text()!='')
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
        var assetCode=$("#assetCODE").val();
        var assetType=$("#assetType").val();
        var assetModel=$("#assetModel").val();
        var assetBrand=$("#assetBrand").val();
        var assetSite=$("#assetSite").val();
        var assetStatus=$("#assetStatus").val();
        var assetIp=$("#assetIp").val();
    $("#editASSET").on('click',function(){
        
    if($("#editASSET").text()=='Edit')
    {
        
        $(".editable").prop("disabled",false);
        $(".editable").addClass("activated");
        $(this).text('Save');
        
    }
    else
    {
        //acquiring datas
        var assetCodeMOD=$("#assetCODE").val();
        var assetTypeMOD=$("#assetType").val();
        var assetModelMOD=$("#assetModel").val();
        var assetBrandMOD=$("#assetBrand").val();
        var assetSiteMOD=$("#assetSite").val();
        var assetStatusMOD=$("#assetStatus").val();
        var assetIpMOD=$("#assetIp").val();
        //posting data
        
        if(assetCode!=assetCodeMOD ||assetType!=assetTypeMOD ||assetModel!=assetModelMOD || assetBrand!=assetBrandMOD || assetSite!=assetSiteMOD || assetStatus!=assetStatusMOD || assetIp!=assetIpMOD)
        {
            $.post('../configuration/job.php',
               {
                updateASSET:1,
                originalAssetCode:assetCode,
                assetCode:assetCodeMOD,
                assetType:assetTypeMOD,
                assetModel:assetModelMOD,
                assetBrand:assetBrandMOD,
                assetSite:assetSiteMOD,
                assetStatus:assetStatusMOD,
                assetIp:assetIpMOD,
                
               },
               function(data)
               {
                alert(data);
               });
        }
        else alert('Asset was not modified');
        
        $(".editable").prop("disabled",true);
        $(".editable").removeClass("activated");
        $(this).text('Edit');
    }
    //closing on click
    });
});

//manage create button
$(document).ready(function(){
   $("#createASSET").click(function(){
    //acquire datas
    var assetCode=$("#assetCODE").val();
    var assetType=$("#assetType").val();
    var assetModel=$("#assetModel").val();
    var assetBrand=$("#assetBrand").val();
    var assetSite=$("#assetSite").val();
    var assetIp=$("#assetIp").val();
    
    //checking inputs
    var token='';
    var go=true;
    switch (token)
    {
        case assetCode:
                                alert('Asset\'s code is empty!');
                                break;
        case assetType:
                                alert('Asset\'s type is empty!');
                                go=false;
                                break;
        case assetSite:
                                alert('Site is empty!');
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
            createASSET:1,
            assetCode:assetCode,
            assetType:assetType,
            assetModel:assetModel,
            assetBrand:assetBrand,
            assetSite:assetSite,
            assetIp:assetIp
           },
           function(data)
           {
            if (data[0]=='yes')
            {
                alert('Created Asset: '+data[1]);
                var assCODE=data[1];
                var url='assetWindow.php?id='+assCODE;
                var wName='ASSET ID:'+assCODE;
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
    $("#closeASSET").click(function(){
        window.close();
    });
});