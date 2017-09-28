<?php
session_start();
if($_SESSION['rollNumber']=="ADMIN" || $_SESSION['rollNumber']=="admin"){
  $navbarPageName = "Admin Panel";
  $navbarRollNumber = strtoupper($_SESSION['rollNumber']);
} else {
  header("location:logout.php");
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin | Physics Lab</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include 'styles.php';?>
  <link rel="stylesheet" href="styles/signup-style.css">
</head>

<body class="bg-signup">
  <?php include 'header.php';?> 
  <?php
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
    $sql = "SELECT * FROM Users ORDER BY rollNumber";
    $result = $conn->query($sql);
  ?>
  <div class="container" style="margin-top:90px">
    <div class="admin-users">
      <table class="table table-hover table-responsive">
        <thead>
          <tr>
            <th>Roll Number</th>
            <th>Name</th> 
            <th>Email</th>
            <th>Registered</th>
            <th>Certified</th>
          </tr>
        </thead>
        <div class="tablebody">
          <tbody>  
            <?php
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    if($row['isRegistered']){
                      $regStatus = "Yes";
                    }else{
                      $regStatus = "No";
                    }
                    if($row['isCertified']){
                      $cerStatus = "Yes";
                    }else{
                      $cerStatus = "No";
                    }
                    echo "<tr>";
                    echo "<td>".$row['rollNumber']."</td>";
                    echo "<td>".$row['name']."</td>";
                    echo "<td>".$row['email']."</td>";
                    echo "<td>".$regStatus."</td>";
                    echo "<td>".$cerStatus."</td>";
                    echo "</tr>";
                }
            }
            $conn->close();
            ?>
          </tbody>
        </div>
      </table>
    </div>
  </div>
  <?php include 'footer.php';?> 
</body>

</html>