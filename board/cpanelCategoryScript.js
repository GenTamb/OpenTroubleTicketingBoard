$(document).ready(function(){
    $("#showCatMenu").click(function(){
        $("#newCat").toggle("slow");
    });
});

$(document).ready(function(){
    $("#showAllCats").click(function(){
        $.post('../configuration/job.php',
               {
                getCategories:1
               },
               function(data)
               {
                $("#catTable").html(data);
               });
    });
});

$(document).ready(function(){
    $("#insertCat").click(function(event){
        event.preventDefault();
        var catName=$("#catName").val();
        var catDesc=$("#catDesc").val();
        if (catName=='' || catDesc=='')
          {
            alert('Error: empty field!');
          }
        else
        {
            $.post("../configuration/job.php",
                   {
                    addCategory:1,
                    catName:catName,
                    catDesc:catDesc
                   },
                   function(data)
                   {
                    alert(data);
                    $('#showAllCats').trigger('click');
                    $("#catName").val('');
                    $("#catDesc").val('');
                    $("#showCatMenu").trigger('click');
                   });
        }
    });     
});

$(document).ready(function(){
    $("#showCategories").on('click','#tableCatName',function()
                         {
                            var catName=$(this).text();
                            var url='cpanelCategory.php?catNameQuery='+catName;
                            window.open(url,'Edit Cat',"width='300',height='300'");
                         });
});

$(document).ready(function(){
    $("#editCat").click(function(event){
        event.preventDefault();
        var originalCatName=$("#originalCatName").val();
        var catName=$("#catName").val();
        var originalCatDesc=$("#originalCatDesc").val();
        var catDesc=$("#catDesc").val();
        if (originalCatName==catName && originalCatDesc==catDesc)
          {
            alert('Old and new values are the same! Category was not modified');
          }
        else
        {
            $.post('../configuration/job.php',
                   {
                    modifyCategory:1,
                    originalCatDesc:originalCatDesc,
                    originalCatName:originalCatName,
                    catName:catName,
                    catDesc:catDesc
                   },
                   function(data)
                   {
                    alert(data);
                    location.reload();
                   });
        }
    });
});

$(document).ready(function(){
    $("#deleteCat").click(function(event){
        event.preventDefault();
        var sure=confirm('Are you sure?');
        if (!sure)
        {
            alert('Category was not deleted');
        }
        else
        {
            var catName=$("#catName").val();
            $.post('../configuration/job.php',
                   {
                    delCategory:1,
                    catName:catName
                   },
                   function(data)
                   {
                    alert(data);
                    window.opener.location.reload();
                    window.close();
                   });
        }
    });
});

$(document).ready(function(){
    $("#close").click(function(event){
        event.preventDefault();
        window.opener.location.reload();
        window.close();
    });
});
