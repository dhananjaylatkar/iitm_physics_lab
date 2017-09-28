<?php
session_start();
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
$email = $password = $name = $rollNumber = $confirm = "";
$emailErr = $passwordErr = $nameErr = $rollNumberErr = $confirmErr = " ";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "* Name is required";
  } else {
    $name = test_input($_POST["name"]);
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $nameErr = "* Only letters and white space allowed"; 
    } else{
      $nameErr = "";
    }
  }

  if (empty($_POST["email"])) {
    $emailErr = "* Email is required";
  } else {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "* Invalid email format"; 
    } else{
      $emailErr = "";
    }
  }

  if (empty($_POST["rollNumber"])) {
    $rollNumberErr = "* Roll Number is required";
  } else {
    $rollNumber = test_input($_POST["rollNumber"]);
    $rollNumber = strtoupper($rollNumber);
  }
  // check for unique roll number
  $sql = "SELECT rollNumber FROM Users";
  $rollNumberFromData = $conn->query($sql);
  $duplicateRollNumber = 0;
  if ($rollNumberFromData->num_rows > 0) {
      // output data of each row
      while($row = $rollNumberFromData->fetch_assoc()) {
          if($row["rollNumber"] == $rollNumber){
            $duplicateRollNumber++;
          }
      }    
  }
  if($duplicateRollNumber != 0){
    $rollNumberErr = "Roll Number already exist";
  } else{
    $rollNumberErr = "";
  }

  if (empty($_POST["password"])) {
    $passwordErr = "* Password is required";
  } else {
    $password = test_input($_POST["password"]);
    $password = hash('sha512',$password);
    $passwordErr = "";
  }
  $confirm = $_POST["confirm"];
  $confirm = hash('sha512',$confirm);
  if ($confirm != $password) {
    $confirmErr = "* Passwords do not match";
  } else{
    $confirmErr = "";
  }

  if(empty($emailErr) && empty($nameErr) && empty($rollNumberErr) && empty($passwordErr) && empty($confirmErr)){
    
    // prepare and bind
    $stmt = $conn->prepare("INSERT INTO Users (name, rollNumber, email, password, isRegistered, isCertified) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssii", $nameInsert, $rollNumberInsert, $emailInsert, $passwordInsert, $isRegisteredInsert, $isCertifiedInsert );
  
    // set parameters and execute
    $nameInsert = $name;
    $rollNumberInsert = $rollNumber;
    $emailInsert = $email;
    $passwordInsert = $password;
    $isRegisteredInsert = 0;
    $isCertifiedInsert = 0;
    
    $stmt->execute();
    $stmt->close();
    $_SESSION['rollNumber'] = $rollNumber;
    $conn->close();
    header("Location: dashboard_users.php");
  
  } else{
    $conn->close();
  }
}




?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Sign Up | Physics Lab</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include 'styles.php';?>  
  <link rel="stylesheet" href="styles/signup-style.css">
</head>

<body class="bg-signup">
<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand" href="index.php"><strong>Physics Lab</strong> Sign Up</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="index.php">Login</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container">
<div class="row main">
  <div class="main-login main-center animate">
  <h2>Sign Up</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      
      <div class="form-group">
        <label for="name" class="cols-sm-2 control-label">Your Name</label>
        <div class="cols-sm-10">
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
            <input type="text" class="form-control" name="name" placeholder="Enter your Name" value="<?php echo $name;?>"/>
          </div>
          <span class="error"> <?php echo $nameErr;?></span>
        </div>
      </div>

      <div class="form-group">
        <label for="rollNumber" class="cols-sm-2 control-label">Roll Number</label>
        <div class="cols-sm-10">
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
            <input type="text" class="form-control" name="rollNumber" placeholder="Enter your Roll Number" value="<?php echo $rollNumber;?>"/>
          </div>
          <span class="error"> <?php echo $rollNumberErr;?></span>
        </div>
      </div>

      <div class="form-group">
        <label for="email" class="cols-sm-2 control-label">Your Email</label>
        <div class="cols-sm-10">
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
            <input type="text" class="form-control" name="email" placeholder="Enter your Email" value="<?php echo $email;?>"/>
          </div>
          <span class="error"> <?php echo $emailErr;?></span>
        </div>
      </div>

      <div class="form-group">
        <label for="password" class="cols-sm-2 control-label">Password</label>
        <div class="cols-sm-10">
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
            <input type="password" class="form-control" name="password" placeholder="Enter your Password"/>
          </div>
          <span class="error"> <?php echo $passwordErr;?></span>
        </div>
      </div>

      <div class="form-group">
        <label for="confirm" class="cols-sm-2 control-label">Confirm Password</label>
        <div class="cols-sm-10">
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
            <input type="password" class="form-control" name="confirm"  placeholder="Confirm your Password"/>
          </div>
          <span class="error"> <?php echo $confirmErr;?></span>
        </div>
      </div>

      <div class="form-group ">
      <button class="btn btn-primary btn-lg btn-block login-button myButton" style="background-color: #1abc9c" type="submit">Register</button>  
      </div>
      
    </form>
  </div>
</div>
</div>
<?php include 'footer.php';?>
</body>

</html>