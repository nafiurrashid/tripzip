<?php 
//strat the session
  session_start(); 
//check if session data are collected
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

<?php
  // Create database connection
  $db = mysqli_connect("localhost", "root", "", "registration");

  // Initialize message variable
  $msg = "";

  // If upload button is clicked ...
  if (isset($_POST['upload'])) {
  	// Get image name
  	$image = $_FILES['image']['name'];
  	// Get text
  	$image_text = mysqli_real_escape_string($db, $_POST['image_text']);

  	// image file directory
  	$target = "images/".basename($image);

  	$sql = "INSERT INTO images (image, image_text, timestamp,username) VALUES ('$image', '$image_text',NOW(), '{$_SESSION['username']}')";
//	$sql = mysql_query("INSERT INTO images (image, image_text, timestamp,username) VALUES('','$image','$image_text',NOW(),'{$_SESSION['username']}')");  
	  // execute query
  	mysqli_query($db, $sql);

  	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
  		$msg = "Image uploaded successfully";
  	}else{
  		$msg = "Failed to upload image";
  	}
  }
  $result = mysqli_query($db, "SELECT * FROM images order by timestamp desc");
?>



<!DOCTYPE html>
<html>
<head>
<title>Image Upload</title>
<style type="text/css">
   #content{
   	width: 50%;
   	margin: 20px auto;
   	border: 1px solid #cbcbcb;
   }
   
   form{
   	width: 50%;
   	margin: 20px auto;
   }
   form div{
   	margin-top: 5px;
   }
   #img_div{
   	width: 80%;
   	padding: 5px;
   	margin: 15px auto;
   	border: 1px solid #cbcbcb;
   }
   #img_div:after{
   	content: "";
   	display: block;
   	clear: both;
   }
   img{
   	float: left;
   	margin: 5px;
   	width: 300px;
   	height: 140px;
   }
</style>
</head>

<body>

<form method="POST" action="cms.php" enctype="multipart/form-data">
  	<input type="hidden" name="size" value="1000000">
  	<div>
  	  <input type="file" name="image">
  	</div>
  	<div>
      <textarea 
      	id="text" 
      	cols="200" 
      	rows="4" 
      	name="image_text" 
      	placeholder="Say something about this image..."></textarea>
  	</div>
  	<div>
  		<button type="submit" name="upload">POST</button>
  	</div>
  </form>

<div id="content">
<?php  if (isset($_SESSION['username'])) : ?>
    	<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
		<p>Hi <?php echo $_SESSION['username']?>! what would be your next exploration? </p>
    <?php endif ?>
  <?php
    while ($row = mysqli_fetch_array($result)) {
		
		echo "<div id='img_div'>";
		echo "<p>"  .$row['username'].' on '.$row['timestamp']."</p>";
		//echo "<p>".$row['timestamp']."</p>";
      	echo "<img src='images/".$row['image']."' >";
		  //echo "<p>" .'Posted by ' .$row['username']."</p>"; 
		  echo "<p>".$row['image_text']."</p>";
		  
          
      echo "</div>";
    }
  ?>


</div>
</body>
</html>