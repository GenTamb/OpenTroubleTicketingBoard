//disable all fields
$(document).ready(function(){
    if ($("#assetCODE").val()!='')
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
        var assetAssignee=$("#assetAssignee").val();
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
        var assetAssigneeMOD=$("#assetAssignee").val();
        //posting data
       
        if(!isNaN(assetAssigneeMOD) && (assetCode!=assetCodeMOD ||assetType!=assetTypeMOD ||assetModel!=assetModelMOD || assetBrand!=assetBrandMOD || assetSite!=assetSiteMOD || assetStatus!=assetStatusMOD || assetIp!=assetIpMOD || assetAssignee!=assetAssigneeMOD))
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
                assetAssignee:assetAssigneeMOD
               },
               function(data)
               {
                alert(data);
               });
            //updating asset List
            $.post('../configuration/job.php',
                   {
                    updateAssetList:1,
                    assetCode:assetCodeMOD,
                    originalAssetAssignee:assetAssignee,
                    assetAssignee:assetAssigneeMOD
                   },
                   function(data)
                   {
                    $("#assigneName").val(data);
                   }
                   );
        }
        else alert('Asset was not modified');
        
        $(".editable").prop("disabled",true);
        $(".editable").removeClass("activated");
        $(this).text('Edit');
        //location.reload();
        
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
    var assetAssignee=$("#assetAssignee").val();
    
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
    if (isNaN(assetAssignee))
    {
        alert('Assignee field can accept only numbers (Customer\'s ID)');
        go=false;
    }
    //posting datas to create Asset
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
            assetIp:assetIp,
            assetAssignee:assetAssignee
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


/******************************************************************************************************************************
 ******************************************************************************************************************************
 ******************************************************************************************************************************
                                                    script for pickToken.php
 ******************************************************************************************************************************
 ******************************************************************************************************************************
 ******************************************************************************************************************************/                                                
//pick Assignee - pickToken opener
$(document).ready(function(){
    $("#assigneLabel").click(function(e){
        if($("#editASSET").text()=='Edit')
        {
            e.preventDefault();
        }
        else
        {
        var url='pickToken.php?choose=assignee';
        var wName='Pick Assignee';
        window.open(url,wName, 'width=350, height=600');
        }   
    });
});



//close customer window
$(document).ready(function(){
    $("#closeASSET").click(function(){
        window.close();
    });
});

//enable tooltip
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    $('#asideLeft').on('mouseover','[data-toggle="tooltip"]',function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
});