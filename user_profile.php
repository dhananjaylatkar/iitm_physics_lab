<?php
session_start();
if(!isset($_SESSION['rollNumber'])){
  header("location:logout.php");
}
$navbarPageName = "Edit Profile";
$navbarRollNumber = strtoupper($_SESSION['rollNumber']);

$servername = 'localhost';
$username = 'root';
$password2 = '';
$dbname = "Users";

// Create connection
$conn = new mysqli($servername, $username, $password2, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$emailErr = $passwordErr = $nameErr = $confirmErr = " ";
$rollNumberErr = "";
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["updateName"])) {
    $nameErr = "* Name is required";
  } else {
    $updateName = test_input($_POST["updateName"]);
    if (!preg_match("/^[a-zA-Z ]*$/",$updateName)) {
      $nameErr = "* Only letters and white space allowed"; 
    } else{
      $nameErr = "";
    }
  }

  if (empty($_POST["updateEmail"])) {
    $emailErr = "* Email is required";
  } else {
    $updateEmail = test_input($_POST["updateEmail"]);
    if (!filter_var($updateEmail, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "* Invalid email format"; 
    } else{
      $emailErr = "";
    }
  }

  if (!empty($_POST["updatePassword"])) {
    $updatePassword = test_input($_POST["updatePassword"]);
    $updatePassword = hash('sha512',$updatePassword);
    $passwordErr = "";
    $updateConfirm = $_POST["updateConfirm"];
    $updateConfirm = hash('sha512',$updateConfirm);
    if ($updateConfirm != $updatePassword) {
      $confirmErr = "* Passwords do not match";
    } else{
      $confirmErr = "";
    }
  } else{
    $passwordErr = "";
    $confirmErr = "";
  }
  
  if(empty($emailErr) && empty($nameErr) && empty($passwordErr) && empty($confirmErr)){
    $sqlupdate = "UPDATE Users SET email='$updateEmail', name='$updateName' WHERE rollNumber='".$_SESSION["rollNumber"]."'";
    $conn->query($sqlupdate);
    if (!empty($_POST["updatePassword"])){
      $sqlupdatepassword = "UPDATE Users SET password='$updatePassword' WHERE rollNumber='".$_SESSION["rollNumber"]."'";
      $conn->query($sqlupdatepassword);
    }
    echo '<div class="alert alert-success alert-dismissablealert-dismissable fade in container myAlert"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Successfully updated</div>';
  }
  
}
$sql = "SELECT * FROM Users WHERE rollNumber='".$_SESSION["rollNumber"]."'";
$user = $conn->query($sql);
$userDetails = $user->fetch_assoc();
$conn->close();
?>


<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Profile | Physics Lab</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include 'styles.php';?>
  <link rel="stylesheet" href="styles/signup-style.css">
</head>

<body class="bg-signup">
<?php include 'header.php';?> 
<div class="container" style="margin-top:90px">
  <div class="row main">
    <div class="main-login main-center">
      <h2>Edit Profile</h2>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        
        <div class="form-group">
          <label for="name" class="cols-sm-2 control-label">Your Name</label>
          <div class="cols-sm-10">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
              <input type="text" class="form-control" name="updateName" value="<?php echo $userDetails['name'];?>"/>
            </div>
            <span class="error"> <?php echo $nameErr;?></span>
          </div>
        </div>

        <div class="form-group">
          <label for="rollNumber" class="cols-sm-2 control-label">Roll Number</label>
          <div class="cols-sm-10">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
              <input type="text" class="form-control" name="updateRollNumber" value="<?php echo $userDetails['rollNumber'];?>" readonly/>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="email" class="cols-sm-2 control-label">Your Email</label>
          <div class="cols-sm-10">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
              <input type="text" class="form-control" name="updateEmail" value="<?php echo $userDetails['email'];?>"/>
            </div>
            <span class="error"> <?php echo $emailErr;?></span>
          </div>
        </div>

        <div class="form-group">
          <label for="password" class="cols-sm-2 control-label">Password</label>
          <div class="cols-sm-10">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
              <input type="password" class="form-control" name="updatePassword" placeholder="Enter new Password"/>
            </div>
            <span class="error"> <?php echo $passwordErr;?></span>
          </div>
        </div>

        <div class="form-group">
          <label for="confirm" class="cols-sm-2 control-label">Confirm Password</label>
          <div class="cols-sm-10">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
              <input type="password" class="form-control" name="updateConfirm"  placeholder="Confirm your Password"/>
            </div>
            <span class="error"> <?php echo $confirmErr;?></span>
          </div>
        </div>

        <div class="form-group ">
          <button class="btn btn-primary btn-lg btn-block login-button myButton" style="background-color: #1abc9c" type="submit">Update</button>  
        </div>  
      </form>
    </div>
  </div>
</div>
<?php include 'footer.php';?> 
</body>
</html>