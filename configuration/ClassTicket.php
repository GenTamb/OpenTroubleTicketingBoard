<?php
include_once 'configuration/db.php';
include_once 'db.php';

class Ticket
{
    public $id,$asset,$status,$category,$customerName,$customerSurname,$site,$openedBy,$assignedTo,$groupAssigned,$description,$solution,$openTime,$closeTime,$number;
    public function __construct()
    {
        $this->id='';
        $this->asset='';
        $this->status='';
        $this->customerName='';
        $this->customerSurname='';
        $this->site='';
        $this->openedBy='';
        $this->assignedTo='';
        $this->groupAssigned='';
        $this->description='';
        $this->solution='';
        $this->openTime='';
        $this->closeTime='';
        $this->number=0;
    }
    public function __destruct()
    {
        unset($this->id,$this->asset,$this->status,$this->category,$this->customerName,$this->customerSurname,$this->site,$this->openedBy,$this->assignedTo,$this->groupAssigned,$this->description,$this->solution,$this->openTime,$this->closeTime,$this->number);
    }
    
    public function getTicketBy($token)
    {
        $connection=new mysqli(HOST,USER,PSW,DB);
        $query="SELECT * FROM tickets WHERE id LIKE '".$token."%' ||
                                            asset LIKE '".$token."%' ||
                                            status LIKE '".$token."%' ||
                                            category LIKE '".$token."%' ||
                                            customerName LIKE '".$token."%' ||
                                            customerSurname LIKE '".$token."%' ||
                                            site LIKE '".$token."%' ||
                                            openedBy LIKE '".$token."%' ||
                                            assignedTo LIKE '".$token."%' ||
                                            groupAssigned LIKE '".$token."%' ||
                                            openTime LIKE '".$token."%' ||
                                            closeTime LIKE '".$token."%'";
        if(!$exec=$connection->query($query))
        {
            $response=false;
        }
        else
        {
           while($res=$exec->fetch_assoc())
           {
            $this->id[]=$res['id'];
            $this->asset[]=$res['asset'];
            $this->status[]=$res['status'];
            $this->category[]=$res['category'];
            $this->customerName[]=$res['customerName'];
            $this->customerSurname[]=$res['customerSurname'];
            $this->site[]=$res['site'];
            $this->openedBy[]=$res['openedBy'];
            $this->assignedTo[]=$res['assignedTo'];
            $this->groupAssigned[]=$res['groupAssigned'];
            $this->description[]=$res['description'];
            $this->solution[]=$res['solution'];
            $this->openTime[]=$res['openTime'];
            $this->closeTime[]=$res['closeTime'];
            $this->number++;
            }
            $response=true;
        }
        return $response;
    }
    
    
    public function printTicketList()
    {
        if($this->number==0)
        {
            $response=false;
        }
        else
        {
            $counter=0;
            echo "<ul id='tktList'>";
            while($counter<$this->number)
            {
                echo "<li><a id='id' href='#".$this->id[$counter]."'>".$this->id[$counter]."</a></li>";
                echo "<li><a id='asset' href='#".$this->asset[$counter]."'>".$this->asset[$counter]."</a></li>";
                echo "<li><a id='status' href='#".$this->status[$counter]."'>".$this->status[$counter]."</a></li>";
                echo "<li><a id='category' href='#".$this->category[$counter]."'>".$this->category[$counter]."</a></li>";
                echo "<li><a id='customerName' href='#".$this->customerName[$counter]."'>".$this->customerName[$counter]."</a></li>";
                echo "<li><a id='customerSurname' href='#".$this->customerSurname[$counter]."'>".$this->customerSurname[$counter]."</a></li>";
                echo "<li><a id='site' href='#".$this->site[$counter]."'>".$this->site[$counter]."</a></li>";
                echo "<li><a id='openedBy' href='#".$this->openedBy[$counter]."'>".$this->openedBy[$counter]."</a></li>";
                echo "<li><a id='assignedTo' href='#".$this->assignedTo[$counter]."'>".$this->assignedTo[$counter]."</a></li>";
                echo "<li><a id='groupAssigned' href='#".$this->groupAssigned[$counter]."'>".$this->groupAssigned[$counter]."</a></li>";
                echo "<li><a id='description' href='#".$this->description[$counter]."'>".$this->description[$counter]."</a></li>";
                echo "<li><a id='solution' href='#".$this->solution[$counter]."'>".$this->solution[$counter]."</a></li>";
                echo "<li><a id='openTime' href='#".$this->openTime[$counter]."'>".$this->openTime[$counter]."</a></li>";
                echo "<li><a id='closeTime' href='#".$this->closeTime[$counter]."'>".$this->closeTime[$counter]."</a></li>";
                $counter++;
            }
            echo "</ul>";
            $response=true;
        }
        return $response;
    }
}