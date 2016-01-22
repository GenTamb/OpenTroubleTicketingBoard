<?php
include_once '../configuration/db.php';
include_once '../configuration/ClassUser.php';
include_once '../configuration/ClassAsset.php';
include_once '../configuration/ClassCustomer.php';

include_once '../function/funcs.php';

if(isset($_POST['searchCustomer']))
{
    $str=$_POST['surname'];
    if(strlen($str)<4) echo "Hints are avaiable for 4 or more chars";
    else
    {
        $customers=new Customer;
        $customers->getCustomerBy($str);
        echo "<div id='hints'>";
        if($customers->number>0 && in_array('active',$customers->status))
        {
            $counter=0;
            while($counter<$customers->number)
            {
                if($customers->status[$counter]=='active') echo "<span class='customerHintSN'>".$customers->surname[$counter].",".$customers->name[$counter]."</span>- ID: <a class='customerHint' href='#".$customers->id[$counter]."'>".$customers->id[$counter]."</a><br>";
                $counter++;
            }
        }
        else echo "No customers found";
    echo "</div>";
    }
}

if(isset($_POST['searchAsset']))
{
    $str=$_POST['code'];
    if(strlen($str)<3) echo "Hints are avaiable for 3 or more chars";
    else
    {
        $assets=new Asset;
        $assets->getAssetBy($str);
        echo "<div id='hints'>";
        if($assets->number>0 && in_array('active',$assets->status))
        {
            $counter=0;
            while($counter<$assets->number)
            {
                if($assets->status[$counter]=='active') echo "<li><a class='assetHint' href='#".$assets->code[$counter]."'>".$assets->code[$counter]."</a></li>";
                $counter++;
            }
        }
        else echo "No asset found";
    echo "</div>";
    }
}



?>