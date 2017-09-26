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

<form class="modal-content animate col-md-5" action="dashboard_useers.php">
  <div class="container">
    <input class="col-md-2" type="text" placeholder="Roll Number" name="rollNumber" required> 
    <input class="col-md-2" type="password" placeholder="Password" name="password" required>
      
    <button class="col-md-1" type="submit">Login</button>
  </div>

  <div class="container" style="padding-top:0">
    <span class="psw">Forgot <a href="#">password?</a></span>
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