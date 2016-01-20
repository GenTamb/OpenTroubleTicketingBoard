<?php
include_once 'configuration/db.php';
include_once 'db.php';
include_once '../configuration/db.php';


class Customer
{
    public $id=array();
    public $name=array();
    public $surname=array();
    public $type=array();
    public $site=array();
    public $status=array();
    public $CTN;
    public $assetList=array();
    public $number;
    
    function __construct()
    {
      /*$this->id[]='';
      $this->name[]='';
      $this->surname[]='';
      $this->type[]='';
      $this->site[]='';
      $this->status[]='';*/
      //getting Custom Customer Name
      $connection=new mysqli(HOST,USER,PSW,DB);
      $getCTN="SELECT tabName FROM tablelist WHERE tabType='customersTable'";
      $exec=$connection->query($getCTN);
      $row=$exec->fetch_assoc();
      $this->CTN=$row['tabName'];
      
      $this->number=0;
    }
    
    function __destruct()
    {
        $this->id;$this->name;$this->surname;$this->type;$this->site; $this->status;$this->CTN;$this->assetList;$this->number;
    }
    
    public function getCustomerBy($token)
    {
        $connection=new mysqli(HOST,USER,PSW,DB);   
        $query="SELECT id,name,surname,type,site,status,assetList FROM ".$this->CTN." WHERE id LIKE '".$token."%' ||
                                            name LIKE '".$token."%' ||
                                            surname LIKE '".$token."%' ||
                                            type LIKE '".$token."%' ||
                                            site LIKE '".$token."%'";
        if(!$exec=$connection->query($query))
        {
            $response=false;
        }
        else
        {
           while($res=$exec->fetch_assoc())
           {
            $this->id[]=$res['id'];
            $this->name[]=$res['name'];
            $this->surname[]=$res['surname'];
            $this->type[]=$res['type'];
            $this->site[]=$res['site'];
            $this->status[]=$res['status'];
            $this->assetList[]=$res['assetList'];
            $this->number++;
            }
            $response=true;
        }
        $connection->close();
        return $response;
    }
    
    public function printTabledCustomerList($token)
    {
        if($this->number==0)
        {
            $response=false;
        }
        else
        {
            $counter=0;
            echo "<div id='customerResume' class='table-responsive'>
                   <table class='table'>
                     <thead>
                         <tr>
                         <th>ID</th><th>NAME</th><th>TYPE</th><th>SITE</th><th>STATUS</th>
                         </tr>
                     </thead>
                     <tbody>";
            switch ($token)
            {
                case 'all':
                           while($counter<$this->number)
                           {
                           echo "<tr>";
                           echo "<td><a class='CUSTOMERID' id='customerID' href='#".$this->id[$counter]."'>".$this->id[$counter]."</a></td>";
                           echo "<td>".$this->surname[$counter].",".$this->name[$counter]."</td>";
                           echo "<td>".$this->type[$counter]."</td>";
                           echo "<td><a class='CUSTOMERSITE' id='customerSITE' href='#".$this->site[$counter]."'>".$this->site[$counter]."</a></td>";
                           echo "<td>".$this->status[$counter]."</td>";
                           echo "</tr>";
                           $counter++;
                           }
                           break;
                case 'active':
                           while($counter<$this->number)
                           { 
                              if($this->status[$counter]!='de-active')
                              {
                               echo "<tr>";
                               echo "<td><a class='CUSTOMERID' id='customerID' href='#".$this->id[$counter]."'>".$this->id[$counter]."</a></td>";
                               echo "<td>".$this->surname[$counter].",".$this->name[$counter]."</td>";
                               echo "<td>".$this->type[$counter]."</td>";
                               echo "<td><a class='CUSTOMERSITE' id='customerSITE' href='#".$this->site[$counter]."'>".$this->site[$counter]."</a></td>";
                               echo "<td>".$this->status[$counter]."</td>";
                               echo "</tr>";
                               $counter++;
                              }
                              else $counter++;  
                            }
                            break;
                default:
                            break;
            }
            echo "</tbody>
                  </table>
                  </div>";
            $response=true;
        }
        return $response;
    }
        
    
    public function updateCustomer($id,$surname,$name,$type,$site,$status,$assetList)
    {
        $this->id=$id;
        $this->name=$name;
        $this->surname=$surname;
        $this->type=$type;
        $this->site=$site;
        $this->status=$status;
        $this->assetList=$assetList;
        
        $connection=new mysqli(HOST,USER,PSW,DB);
        $query="UPDATE ".$this->CTN." SET name='".$this->name."',surname='".$this->surname."',type='".$this->type."',
        site='".$this->site."',status='".$this->status."',assetList='".$this->assetList."' WHERE id='".$this->id."'";
        if(!$exec=$connection->query($query)) $response=$connection->error;
        else $response="Customer Updated";
        $connection->close();
        return $response;
    }
    
    public function createCustomer($surname,$name,$type,$site)
    {
        $this->name=$name;
        $this->surname=$surname;
        $this->type=$type;
        $this->site=$site;
        $this->status=$status;
        
        $connection=new mysqli(HOST,USER,PSW,DB);
        $query="INSERT INTO ".$this->CTN." (name,surname,type,site,status)
                VALUES ('".$this->name."','".$this->surname."','".$this->type."','".$this->site."','active')";
        if(!$exec=$connection->query($query)) $response=$connection->error;
        else $response=$connection->insert_id;
        $connection->close();
        return $response;
    }
    
    public function getListedAssignedList()
    {
        if($this->assetList[0]=='') echo "NO ASSET ASSIGNED";
        else
        {
        $str=$this->assignedList;
        $slice=explode(",",$str);
        echo "<ul id='assetList'>";
        foreach($slice as $val) echo "<li><a href='#".$val."' class='assetREF'>".$val."</a></li>";
        }
    }
    /*public function getCustomerAssignedAssetList($id)
    {
        $connection=new mysqli(HOST,USER,PSW,DB);
        $query="SELECT assignee FROM assets WHERE assignee='".$id."'";
        $exec=$connection->query($query);
        $num=$exec->num_rows;
        if($num!=0)
        {
            $res=$exec->fetch_assoc();
            $
            
        }
    }*/
    
}




?>