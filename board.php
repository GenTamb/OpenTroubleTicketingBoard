<!DOCTYPE html>
<?php
require_once ("configuration/db.php");
require_once (ROOT."/function/funcs.php");
require_once (ROOT."/configuration/ClassUser.php");
require_once (ROOT."/configuration/ClassTicket.php");
session_start();
checkLogin();
$user=new User;
setupUser($user);
?>
<html>
<head>
<title>OpenTroubleTicketing | Home | <?php echo getBoardName(); ?></title>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<link rel='icon' href='icon/icon.png'/>
<link rel='stylesheet' href='style/bootstrap.min.css'>
<link rel='stylesheet' href='board/boardStyle.css'>
<link rel='stylesheet' href='style/defaultStyle.css'>
<script src='js/jquery.min.js'></script>
<script src='js/bootstrap.min.js'></script>
<script src='board/boardScript.js'></script>
<script src='js/defaultScript.js'></script>
</head>
<body>

<nav class="navbar navbar-default" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="#"><?php echo getBoardName();?></a>
  </div>
  <?php
  if(!checkFirstSetup())
  {
    
  echo "
  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class='collapse navbar-collapse navbar-ex1-collapse'>
    <ul class='nav navbar-nav'>
      <li class='dropdown'>
        <a href='#' class='dropdown-toggle' data-toggle='dropdown'>New..<b class='caret'></b></a>
        <ul class='dropdown-menu'>
            <li><a href='#'>Ticket</a></li>
            ";
            if($user->getPosition()=='admin' || $user->getPosition()=='superuser')
              {
                echo "
            <li><a href='#'>Customer</a></li>
            <li><a href='#'>Asset</a></li>";
              }
        echo "      
        </ul>
      </li>
      <li class='dropdown'>
        <a href='#' class='dropdown-toggle' data-toggle='dropdown'>List All<b class='caret'></b></a>
        <ul class='dropdown-menu'>
          <li><a href='#'>Tickets</a></li>
          <li><a href='#'>Customers</a></li>
          <li><a href='#'>Assets</a></li>
        </ul>
      </li>
    </ul>
    <form class='navbar-form navbar-left' role='search'>
      <div class='form-group'>
        <input type='text' class='form-control' placeholder='Search Ticket by ID'>
      </div>
      <button type='submit' id='searchTicket' class='btn btn-default'>Go</button>
    </form>
    <form class='navbar-form navbar-left' role='search'>
      <div class='form-group'>
        <input type='text' class='form-control' size='30' placeholder='Search Customer by Surname'>
      </div>
      <button type='submit' id='searchCustomer' class='btn btn-default'>Go</button>
    </form>
     <form class='navbar-form navbar-left' role='search'>
      <div class='form-group'>
        <input type='text' class='form-control' placeholder='Search Asset by Code'>
      </div>
      <button type='submit' id='searchAsset' class='btn btn-default'>Go</button>
    </form>
    ";
  }
  else
  {
    doAlert('An admin must complete the first setup procedure.\nUse the control panel on the right!');
  }
  
    ?>
    <ul class='nav navbar-nav navbar-right'>
    <?php if($user->getPosition()=='admin' || $user->getPosition()=='superuser')
          {
             echo "   
             <li><a href='#controlPanel' id='controlPanelButton'>Control Panel</a></li>";
          }
    ?>
    <li class='dropdown'>
    <a href='#' class='dropdown-toggle' data-toggle='dropdown'><?php echo $user->getName()." ".$user->getSurname()."";?> <b class='caret'></b></a>
    <ul class='dropdown-menu'>
    <li><a href='#'>Send a message</a></li>
    <li><a href='#'>Read messages<span class='badge' id='counterMSG'>X</span></a></li>
    <li class='divider'></li>
    <li><a href='#' id='logout'>Logout</a></li>
    </ul>
    </li>
    </ul>
    
  </div><!-- /.navbar-collapse -->
</nav>
<div id='pageBody' class='container'></div>
<div class='modal'></div>
</body>
</html>