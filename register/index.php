<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
	  unset($_SESSION['username']);
	  unset($_SESSION['email']);
  	header("location: login.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="header">
	<h2>Home Page</h2>
</div>
<div class="content">
  	<!-- notification message -->
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>



    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
    	<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
		<p>Hi <?php echo $_SESSION['username']?>! what would be your next exploration? </p>
    <?php endif ?>



<hr><hr>

<h3>Your Profile</h3>

	<?php

	$conn = mysqli_connect("localhost", "root", "", "registration");
 
	// Check connection
	if($conn === false){
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}
	$b=trim($_SESSION['username'])	; 
	//echo gettype($b);
	// Attempt select query execution
	$sql = "SELECT * FROM users where username='$b'";
	if($result = mysqli_query($conn, $sql)){
		if(mysqli_num_rows($result) > 0){
			
			while($row = mysqli_fetch_array($result)){
					echo  "ID: " . $row['id'] . "<br>";
					echo  "Username: " .$row['username'] . "<br>";
					echo  "Email: " .$row['email'] . "<br>";
				echo "<br>";
			}
			

	
			// Close result set
			mysqli_free_result($result);
		} else{
			echo "No records matching your query were found.";
		}
	} else{
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
	}

	// Close connection
	mysqli_close($conn);
	?>

<p>
  		wanna post on you wall? <a href="cms.php">MY Wall</a>
  	</p>
    <?php  if (isset($_SESSION['username'])) : ?>

    	<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
    <?php endif ?>




</div>
		
</body>
</html>