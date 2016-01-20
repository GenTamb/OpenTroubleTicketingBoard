<?php
include_once 'configuration/db.php';
include_once 'db.php';
include_once '../configuration/db.php';


class Asset
{
    
    public $code=array();
    public $type=array();
    public $brand=array();
    public $model=array();
    public $site=array();
    public $ip=array();
    public $status=array();
    public $assignee=array();
    public $number;
    
    function __construct()
    {
      /*$this->code[]='';
      $this->type[]='';
      $this->brand[]='';
      $this->model[]='';
      $this->site[]='';
      $this->status[]='';
      $this->ip[]='';*/      
      $this->number=0;
    }
    
    function __destruct()
    {
        $this->code;$this->type;$this->brand;$this->model;$this->site;$this->status;$this->ip;$this->assignee;$this->number;
    }
    
    public function getAssetBy($token)
    {
        $connection=new mysqli(HOST,USER,PSW,DB);   
        $query="SELECT code,type,brand,model,site,status,ip,assignee FROM assets WHERE code LIKE '".$token."%' ||
                                            type LIKE '".$token."%' || brand LIKE '".$token."%' ||
                                            model LIKE '".$token."%' || site LIKE '".$token."%' ||
                                            status LIKE '".$token."%' || ip LIKE '".$token."%' || assignee LIKE '".$token."%'";
        if(!$exec=$connection->query($query))
        {
            $response=false;
        }
        else
        {
           while($res=$exec->fetch_assoc())
           {
            $this->code[]=$res['code'];
            $this->site[]=$res['site'];
            $this->type[]=$res['type'];
            $this->brand[]=$res['brand'];
            $this->model[]=$res['model'];
            $this->status[]=$res['status'];
            $this->ip[]=$res['ip'];
            $this->assignee[]=$res['assignee'];
            $this->number++;
            }
            $response=true;
        }
        $connection->close();
        return $response;
    }
    
    public function printTabledAssetList($token)
    {
        if($this->number==0)
        {
            $response=false;
        }
        else
        {
            $counter=0;
            echo "<div id='assetResume' class='table-responsive'>
                   <table class='table'>
                     <thead>
                         <tr>
                         <th>CODE</th><th>TYPE</th><th>STATUS</th><th>ASSIGNEE</th>
                         </tr>
                     </thead>
                     <tbody>";
            switch ($token)
            {
                case 'all':
                           while($counter<$this->number)
                           {
                           echo "<tr>";
                           echo "<td><a class='ASSETCODE' id='assetCODE' href='#".$this->code[$counter]."'>".$this->code[$counter]."</a></td>";
                           echo "<td>".$this->type[$counter]."</td>";
                           echo "<td>".$this->status[$counter]."</td>";
                           echo "<td>".$this->assignee[$counter]."</td>";
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
                                echo "<td><a class='ASSETCODE' id='assetCODE' href='#".$this->code[$counter]."'>".$this->code[$counter]."</a></td>";
                                echo "<td>".$this->type[$counter]."</td>";
                                echo "<td>".$this->status[$counter]."</td>";
                                echo "<td>".$this->assignee[$counter]."</td>";
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
        
    
    public function updateAsset($originaleCode,$code,$type,$brand,$model,$site,$ip,$status,$assignee)
    {
        $this->code=$code;
        $this->type=$type;
        $this->brand=$brand;
        $this->model=$model;
        $this->site=$site;
        $this->ip=$ip;
        $this->status=$status;
        $this->assignee=$assignee;
        
        $connection=new mysqli(HOST,USER,PSW,DB);
        $query="UPDATE assets SET code='".$this->code."',type='".$this->type."',brand='".$this->brand."',
        model='".$this->model."',site='".$this->site."', ip='".$this->ip."',status='".$this->status."',assignee='".$this->assignee."' WHERE code='".$originaleCode."'";
        if(!$exec=$connection->query($query)) $response=$connection->error;
        else $response="Asset Updated";
        $connection->close();
        return $response;
    }
    
    public function createAsset($code,$type,$brand,$model,$site,$ip,$assignee)
    {
        $this->code=$code;
        $this->type=$type;
        $this->brand=$brand;
        $this->model=$model;
        $this->site=$site;
        $this->ip=$ip;
        $this->assignee=$assignee;
        
        $connection=new mysqli(HOST,USER,PSW,DB);
        $query="INSERT INTO assets (code,type,brand,model,site,ip,status,assignee)
                VALUES ('".$this->code."','".$this->type."','".$this->brand."','".$this->model."','".$this->site."','".$this->ip."','active','".$this->assignee."')";
        if(!$exec=$connection->query($query)) $response=$connection->error;
        else $response=$this->code;
        $connection->close();
        return $response;
    }
    
}




?>