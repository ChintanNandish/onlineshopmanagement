<?php

$name=$_POST["name"];
$email=$_POST["email"];
$message=htmlspecialchars($_POST["message"]);
$c=mysqli_connect("localhost","id5196215_localhost","localhost");
$z=mysqli_select_db($c,"id5196215_onlineshopmaker");
$au="insert into feedback values('','".$name."','".$email."','".$message."')";
$aa=mysqli_query($c,$au);
if($aa){
	echo '<script language="javascript">
	alert("Feedback Recieved!!!")
	window.location.href="index.php"
	</script>';
}
else{
	echo '<script language="javascript">
	alert("Something Went Wrong!!!")
	window.location.href="index.php"
	</script>';
}
?>