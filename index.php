<?php
// start a session
session_start();
if(isset($_SESSION['rollNumber'])){
  header("location:dashboard_users.php");
}
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

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// define variables and set to empty values
$password =$rollNumber = "";
$passwordErr = $rollNumberErr = $loginError =" ";


if ($_SERVER["REQUEST_METHOD"] == "POST") {


  if (empty($_POST["rollNumber"])) {
    $rollNumberErr = "* Roll Number is required";
  } else {
    $rollNumber = test_input($_POST["rollNumber"]);
    $rollNumberErr = "";
  }
  if (empty($_POST["password"])) {
    $passwordErr = "* Password is required";
  } else {
    $password = test_input($_POST["password"]);
    $password = hash('sha512',$password);
    $passwordErr = "";
  }
  if(empty($rollNumberErr) && empty($passwordErr)){
    $query = "SELECT rollNumber, password FROM Users WHERE rollNumber='".$rollNumber."' and password='".$password."' ";
    
    $exeQuery = $conn->query($query);
    $row = $exeQuery->fetch_assoc();
    $count = mysqli_num_rows($exeQuery);
    
    if($count == 1) {
      $_SESSION['rollNumber'] = $rollNumber;
      $conn->close();
      header("location: dashboard_users.php");
    } else {
      $conn->close();
      $loginError = "Roll number or Password is invalid";
    }
  } else{
    $conn->close();
  }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Physics Lab</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include 'styles.php';?>  
</head>

<body>
<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand" href="index.php"><strong>Physics Lab</strong></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="signup.php">Sign Up</a></li>
        <li><a onclick="document.getElementById('id01').style.display='block'" href="#">Login</a></li>
      </ul>
    </div>
  </div>
</nav>
  <div class="container-fluid bg-1 text-center">
    <h3 class="margin">Physics Lab</h3>
    <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</h3>
  </div>
  <div class="container-fluid bg-2 text-center">
    <h3 class="margin">Physics Lab</h3>
    <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</h3>
  </div>
<!-- Login Modal -->
<div id="id01" class="modal">

<form class="modal-content animate col-md-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
<div class="form-group" style="padding-top:15px">
  <div class="cols-sm-10">
    <div class="input-group">
      <span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
      <input type="text" class="form-control" name="rollNumber" placeholder="Enter your Roll Number" />
    </div>
  <span class="error"><?php echo $rollNumberErr;?></span>
  </div>
</div>

<div class="form-group">
  <div class="cols-sm-10">
    <div class="input-group">
      <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
      <input type="password" class="form-control" name="password" placeholder="Enter your Password"/>
    </div>
    <span class="error"><?php echo $passwordErr;?></span>
  </div>
</div>
<span class="error"><?php echo $loginError;?></span>
<div class="form-group ">
  <button class="btn btn-primary btn-block login-button myButton" style="background-color: #1abc9c" type="submit">Login</button>  
</div>
</form>
</div>
  <?php include 'footer.php';?>  
</body>
<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
</html>