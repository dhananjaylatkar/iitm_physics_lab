<?php
session_start();

if(!isset($_SESSION['rollNumber'])){
  header("location:logout.php");
}

$navbarPageName = "Dashborad";
$navbarRollNumber = strtoupper($_SESSION['rollNumber']);

?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Dashborad | Physics Lab</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include 'styles.php';?>
</head>

<body>
<?php include 'header.php';?> 
  <div class="container-fluid bg-1 text-center">
    <h2 class="margin">Apply for test</h2>
    <h3>Click register to apply for a test.</h3>
    <a href="#" class="btn btn-lg applyButton" role="button">Register</a>
  </div>
  <div class="container-fluid bg-2 text-center">
    <h3 class="margin">Physics Lab</h3>
    <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</h3>
  </div>
  <?php include 'footer.php';?> 
</body>
</html>