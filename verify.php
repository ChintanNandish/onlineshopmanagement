<?php

if(isset($_GET['user']) && !empty($_GET['user']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    $c=mysqli_connect("localhost","id5196215_localhost","localhost");
	$z=mysqli_select_db($c,"id5196215_onlineshopmaker");
	$user = mysqli_real_escape_string($c,$_GET['user']);
    $hash = $_GET['hash'];
	$q = mysqli_query($c,"SELECT * FROM user WHERE User_name='".$user."' AND Active=0"); 
	$match  = mysqli_num_rows($q);
	$res = mysqli_fetch_assoc($q);
	if ($match > 0){
		$db_pwd=$res['Password'];
		$db_user=$res['User_name'];
        $db_email=$res['Email'];
		$db_mobile=$res['Phone_no'];
		$db_name=$res['Name'];
        $temp_hash = str_replace("+", " ", openssl_encrypt($db_pwd,"AES-128-ECB",$db_user));
		if($hash == $temp_hash){
			$q=mysqli_query($c,"UPDATE user SET Active=1 WHERE User_name='".$user."' AND Active=0");
            mkdir('user_folders/'.$user);
			$file = fopen('user_folders/'.$user.'/product_data.json', 'w');
			fclose($file);
            $file_owner = fopen('user_folders/'.$user.'/owner_data.json', 'w');
			$root = $user;
			$string = array('name' => (String)$db_name, 'email' => (String)$db_email, 'password' => (String)$db_pwd, 'mobile' => (String)$db_mobile);
			$json_str[(String)$root] = $string;
			fwrite($file_owner, json_encode($json_str));
			fclose($file_owner);
			echo '<script language="javascript">
			alert("Your Account Is Successfully Verified!!!Now You Can Log In with Your Credentials!")
			window.location.href="login.php"
			</script>';
		}
		else{
                        //echo $hash;
                        //echo "<br>".openssl_encrypt($db_pwd,"AES-128-ECB",$db_user);
                        //echo "<br>".$temp_hash;
			echo '<script language="javascript">
			alert("Link is broken or Your account Has Been already verified!!!")
			window.location.href="index.php"
			</script>';
		}
	}
	else{
		echo '<script language="javascript">
		alert("Link is broken or Your account Has Been already verified!!!")
		window.location.href="index.php"
		</script>';
	}
	
}
else{
	echo '<script language="javascript">
	alert("This Link is broken or Your account Has Been already verified!!!")
	window.location.href="index.php"
	</script>';
	}

?>