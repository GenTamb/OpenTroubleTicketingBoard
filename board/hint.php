<?php
include_once '../configuration/db.php';
include_once '../configuration/ClassUser.php';
include_once '../configuration/ClassAsset.php';
include_once '../configuration/ClassCustomer.php';

include_once '../function/funcs.php';

if(isset($_POST['searchCustomer']))
{
    $str=$_POST['surname'];
    if(strlen($str)<=4) echo "Hints are avaiable for 4 or more chars";
    else
    {
        $customers=new Customer;
        $connection=new mysqli(HOST,USER,PSW,DB);
        $customers->getCustomerBy($str);
        echo "<div id='hints'>";
        if($customers->number>0 && in_array('active',$customers->status))
        {
            $counter=0;
            while($counter<$customers->number)
            {
                if($customers->status[$counter]=='active') echo $customers->surname[$counter].",".$customers->name[$counter]."- ID: <a class='hintID' href='#".$customers->id[$counter]."'>".$customers->id[$counter]."</a><br>";
                $counter++;
            }
        }
        else echo "No customers found";
    echo "</div>";
    }
}




?>