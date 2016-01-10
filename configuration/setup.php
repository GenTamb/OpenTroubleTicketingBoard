<!DOCTYPE html>
<head>
  <title>OpenTroubleTicketing: Setup</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="icon/icon.png"/>
  <link rel="stylesheet" href="style/bootstrap.min.css">
  <link rel="stylesheet" href="configuration/setupStyle.css">
  <link rel="stylesheet" href="style/defaultStyle.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="configuration/setupScript.js"></script>
  <script src="js/defaultScript.js"></script>
</head>
<body>
    <div class="container-fluid defaultWidth" id="setupDBform">
        <h2 class="text-center">Fill this form to setup your custom OpenTroubleTicketing</h2>
        <h3>Setup DB</h3>
        <form role="form">
            <div class="form-group">
                <label for="dbName">Enter the name's DB</label>
                <input type="text" class="form-control" id="dbName" size="10" placeholder="DB name">
            </div>
            <div class="form-group">
                <label for="host">Enter your host</label>
                <input type="text" class="form-control" id="host" size="50" placeholder="Usually is localhost">
            </div>
            <div class="form-group">
                <label for="user">Enter username</label>
                <input type="text" class="form-control" id="user" size="15" placeholder="Usually is root">
            </div>
             <div class="form-group">
                <label for="psw">Enter password</label>
                <input type="text" class="form-control" id="psw" size="30" placeholder="Usually is blank">
            </div>
            <div class="form-group">
                <label for="salt">Enter a salt for securing password</label>
                <input type="text" class="form-control" id="salt" size="30" placeholder="Be creative :)">
            </div>
            <input type="submit" id="send1" class="btn btn-warning btn-sm" name='submit' value="Submit"</input>
        </form>
    </div>
    <div class="container-fluid defaultWidth divHidden" id="setupAdminform">
        <h2 class="text-center">Fill this form to setup your custom OpenTroubleTicketing</h2>
        <h3>Setup Admin</h3>
        <form role="form">
            <div class="form-group">
                <label for="adminUserName">Enter the Admin's username</label>
                <input type="text" class="form-control" id="adminUserName" size="10" placeholder="Enter username">
            </div>
            <div class="form-group">
                <label for="adminName">Enter the Admin's name</label>
                <input type="text" class="form-control" id="adminName" size="10" placeholder="Enter name">
            </div>     
            <div class="form-group">
                <label for="adminSurName">Enter the Admin's surname</label>
                <input type="text" class="form-control" id="adminSurName" size="10" placeholder="Enter surname">
            </div>
            <div class="form-group">
                <label for="adminPassword">Enter your Admin's password</label>
                <input type="password" class="form-control" id="adminPassword" size="50" placeholder="Enter password">
            </div>
            <input type="submit" id="send2" class="btn btn-warning btn-sm" name='submit' value="Submit"</input>
        </form>
    </div>
    <div class="container-fluid defaultWidth divHidden" id="setupBoardForm">
        <h2 class="text-center">Fill this form to setup your custom OpenTroubleTicketing</h2>
        <h3>Setup Your Board</h3>
        <form role="form">
            <div class="form-group">
                <label for="boardName">Enter the board's name</label>
                <input type="text" class="form-control" id="boardName" size="10" placeholder="Enter board's name">
            </div>
            <div class="form-group">
                <label for="organizationName">Enter your organization's name</label>
                <input type="text" class="form-control" id="organizationName" size="10" placeholder="Enter organization's name">
            </div>     
            <input type="submit" id="send3" class="btn btn-warning btn-sm" name='submit' value="Submit"</input>
        </form>
    </div>
    <div class="container-fluid defaultWidth divHidden" id="setupComplete">
      <h2>Congratulations!</h2>
      <p>Your setup is done!</p>
      <button class="btn btn-info btn-sm" id="done">Go to your board!</button>
    </div>
<div class="modal"></div>
</body>
</html>
