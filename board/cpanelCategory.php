<?php
            
require_once ('../configuration/db.php');
require_once ('../configuration/ClassUser.php');
require_once ('../function/funcs.php');
session_start();
checkLogin();

$user=new User();
setupUser($user);


if(checkUserAdminOrSuperUser($user))
{
    echo "
    <html>
    <head>
    <title>OpenTroubleTicketing | Edit Categories</title>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='icon' href='icon/icon.png'/>
    <link rel='stylesheet' href='../style/bootstrap.min.css'>
    <link rel='stylesheet' href='cpanelCategoryStyle.css'>
    <link rel='stylesheet' href='../style/defaultStyle.css'>
    <script src='../js/jquery.min.js'></script>
    <script src='../js/bootstrap.min.js'></script>
    <script src='cpanelCategoryScript.js'></script>
    <script src='../js/defaultScript.js'></script>
    </head>
    <body>";
    if(!isset($_GET['catNameQuery']))
    {
    echo "
    
    <div id='addCategory' class='container'>
      <h2 id='showCatMenu' class='entry'>Add a new category</h2>
      <div class='container' id='newCat'>
        <form role='form'>
        <div class='form-group'>
                  <label for='catName'>Enter the category's name</label>
                  <input type='text' class='form-control' id='catName' size='10'>    
        </div>
        <div class='form-group'>
                  <label for='catDesc'>Enter the category's description</label>
                  <textarea row='4' cols='4' class='form-control' id='catDesc' size='500'></textarea>   
        </div>
        <div class='form-group'>
                  <input type='button' value='INSERT' class='btn btn-warning btn-sm' id='insertCat'>
        </div>
        </form>
      </div>  
    </div>
    <div id='showCategories' class='container'>
     <h2 id='showAllCats' class='entry'>Show all categories</h2>
      <div class='container' id='catTable'></div>
    </div>
    </body>
    </html>
    ";
    }
    else
    {
        $catNameEdit=$_GET['catNameQuery'];
        $connection=new mysqli(HOST,USER,PSW,DB);
        $query="SELECT description FROM category WHERE name='".$catNameEdit."'";
        $exec=$connection->query($query);
        $res=$exec->fetch_assoc();
        echo "
      <div id='editCategory' class='container'>
        <form role='form'>
        <div class='form-group'>
                  <label for='catName'>Edit name:</label>
                  <input type='text' class='form-control' id='catName' size='10' value='".$catNameEdit."'>
                  <input type='text' id='originalCatName' class='hidden' value='".$catNameEdit."'>
        </div>
        <div class='form-group'>
                  <label for='catDesc'>Edit description:</label>
                  <textarea row='4' cols='4' class='form-control' id='catDesc' size='500'>".$res['description']."</textarea>
                  <textarea row='4' cols='4' class='hidden' id='originalCatDesc' size='500'>".$res['description']."</textarea>   
        </div>
        <div class='form-group'>
                  <input type='button' value='EDIT' class='btn btn-warning btn-sm' id='editCat'>
                  <input type='button' value='DELETE' class='btn btn-danger btn-sm' id='deleteCat'>
                  <button class='btn btn-info btn-sm' id='close'>CLOSE</button>
        </div>
        </form>
       </div>  
      </div>
        ";
        $connection->close();
    }
}
else echo doAlert('You don\'t have the rights to do this');




?>