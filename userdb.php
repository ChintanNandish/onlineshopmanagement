<?php
$firstname=$_POST["fname"];
$lastname=$_POST["lname"];
$username=$_POST["uname"];
$pwd=$_POST["pwd"];
$email=$_POST["email"];
$mobile='+'.$_POST["country"].' '.$_POST["mob"];
$active=0;



$c=mysqli_connect("localhost","id5196215_localhost","localhost");
$z=mysqli_select_db($c,"id5196215_onlineshopmaker");
$au="select * from user where User_name='".$username."'";
$aa=mysqli_query($c,$au);
$ae="select * from user where Email='".$email."'";
$ab=mysqli_query($c,$ae);
$am="select * from user where Phone_no='".$mobile."'";
$ac=mysqli_query($c,$am);	
if(mysqli_num_rows($aa)>0 || mysqli_num_rows($ab)>0 || mysqli_num_rows($ac)>0)
{
	header("location:signup.php?errorcontentsame");
}
else{
	$encrypted_string=openssl_encrypt($pwd,"AES-128-ECB",$username);
	$to      = $email; // Send email to our user
	$subject = 'Signup | Verification'; // Give the email a subject 
	$message = '
	 
	Thanks for signing up!
	Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
	 
	------------------------
	Username: '.$username.'
	Password: '.$pwd.'
	------------------------
	 
	Please click this link to activate your account:
	http://onlineshopmanagement.000webhostapp.com/verify.php?user='.$username.'&hash='.$encrypted_string.'
	 
	';
						 
	$headers = 'From:mail@onlineshopmanagement.com' . "\r\n"; // Set from headers
	$mail=mail($to, $subject, $message, $headers); // Send our email
	
	if(!$mail) {	
		echo '<script language="javascript">
		alert("Something went wrong!!!")
		window.location.href="signup.php"
		</script>';
	}
 	else{
		$q="insert into user values('','".$firstname.' '.$lastname."','".$username."','".$pwd."','".$email."','".$mobile."','".$active."')";
		mysqli_query($c,$q);
		echo '<script language="javascript">
		alert("We sent an Verification mail on your given address.Please Verify Your email account!")
		window.location.href="signup.php"
		</script>';
	}
}
?>