<?php session_start(); 
if(!isset($_SESSION["username"])){
	$_SESSION['go']=1;
	echo '<script language="javascript">
	alert("You need to Sign In to use this feature!!!")
	window.location.href="login.php"
	</script>';
}
//$fl = fopen('user_folders/'.$_SESSION["username"].'/product_data.json', 'r');
if (filesize('user_folders/'.$_SESSION["username"].'/product_data.json') > 0 && !file_exists('user_folders/'.$_SESSION['username'].'/index.php')){
	header('location:template.php');
}
else if (file_exists('user_folders/'.$_SESSION['username'].'/index.php')){
	header("location:admin-page.php");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Website Builder</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<script src="js/myjs.js"></script>
		<script src="js/list.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCnN1vzotvPpQp18QJW8gWpbWaCHpzP-5w&libraries=places&callback=initAutocomplete" defer></script>
		<script>

		      function initAutocomplete() {
		        autocomplete = new google.maps.places.Autocomplete((document.getElementById('autocomplete')),{types: ['geocode']});
				
		      }
			  function geolocate() {
		        if (navigator.geolocation) {
		          navigator.geolocation.getCurrentPosition(function(position) {
		            var geolocation = {
		              lat: position.coords.latitude,
		              lng: position.coords.longitude
		            };
		            var circle = new google.maps.Circle({
		              center: geolocation,
		              radius: position.coords.accuracy
		            });
		            autocomplete.setBounds(circle.getBounds());
		          });
		        }
				
		      }
		      
		</script>
	</head>
	<body>

		<!-- Header -->
			<header id="header">
				<h1><a href="#">Shop Goes Online Here!</a></h1>
				<nav id="nav">
					<ul>
						<li><a href="index.php">Home</a></li>
						<li><a href="ourgoal.php">Our Goal</a></li>
						<li><a href="#">Website Builder</a></li>
						<?php 
						if(isset($_SESSION["username"])){
							echo '<li><a href="logout.php" class="button special" rel="nofollow" onClick="return confirm(\'Do You Really Want To logout??\');">Logout</a></li>';
						}
						else{
							echo '<li><a href="login.php" class="button special">Sign Up/In</a></li>';
						}
						?>
					</ul>
				</nav>
			</header>

		<!-- Main -->
			<section id="main" class="wrapper">
				<div class="container">

					<header class="major">
						<h2>Builder</h2>
						<p>Here Shop Goes Online</p>
					</header>
					<form method="post" name='builder' action="">
				
					<div id='main_div' align='center'>
					<div id='first_div'>
						<header>
						<h3>Step 1</h3>
						<h3>Note: DO NOT REFRESH PAGE NOW</h3>
						</header>
						<div class="12u 12u$(4)">
							<table>
								<tr>
									<td>Your Shop Name</td>
									<td><input type="text" name="shopname" id="shopname"  placeholder="Shop Name"  required />
									</td>
								</tr>
								<tr>
									<td>How Many Products You Want In Your Shop? </td>
									<td>
									<div name='type' id='type' class="10u$">
										<input type="text" name="product_type" id="product_type" required/>
									</div>
									</td>
								</tr>
								<tr>
									<td>Shop address</td>
									<td>
										<input type="text" name="shop_address" id="shop_address" required/>
									</td>
								</tr>
								<tr>
									<td>Nearest location (Atleast city must be selected)</td>
									<td>
										<div id="locationField">
										<input id="autocomplete" name="autocomplete" placeholder="Start typing and select nearest location" type="text" size="50"></input>
										</div>
									</td>
								</tr>
								<tr>
									<td>Contact Email (User feedbacks will be sent here)</td>
									<td>
										<input type="Email" name="contact_email" id="contact_email" required/>
									</td>
								</tr>
								<tr>
									<td>Contact mobile (Will be shown in website)</td>
									<td>
										<input type="Email" name="contact_mobile" id="contact_mobile" required/>
									</td>
								</tr>
								<tr>
									<td>Product price currency</td>
									<td>
										<select id="product_currency" name="product_currency">
											<option value="rupee">rupee</option>
											<option value="dollar">dollar</option>
											<option value="GBP">Britain pound</option>
										</select>
									</td>
								</tr>
							</table>
						</div>
						</div>
						<!-- <div id="next_button_div" style="display:none;">
							<input type="button" id="next_button" name="next_button" value="next entry" class="special">
						</div> -->
						<div id='hidden_second' style='display:none;'></div>
						<div class="12u$" id='before_submit'>
							<ul class="actions">
								<li><input type="button" id='submit_button' name='next_button' value="Submit" class="special" onclick="last_check();" /></li>
								<li><input type="button" id='reset_button' name='reset_button' value="Reset" onclick='form_reset();'/></li>
							</ul>
						</div>

						<div id='final_submit' style="display:none;">
							<ul class="actions">
								<li><input type="button" id='button_last_submit' name='button_last_submit' value="Submit" class="special" onclick="last_submit();" /></li>
								<li><input type="button" id='preview_product' name='preview_product' value="Preview products" class="special" onclick="window.open('preview-products.php','_blank');" /></li>
								<li><input type="button" id='download_data' name='download_data' value="download data in excel" class="special"onclick="window.open('download-product-data.php','_blank');" /></li>
							</ul>
						</div>
					</div>
				</form>
						
				</div>
			</section>

		<!-- Footer -->
			<footer id="footer">
				<div class="container">
					<section class="links">
						<div class="row">
							<section class="3u 6u(medium) 12u$(small)">
								<h3>Online Shop Maker</h3>
								<ul class="unstyled">
									<li><a href="index.php">Home</a></li>
									<li><a href="login.php">Register/Log In</a></li>
									<li><a href="ourgoal.php">Our Goal</a></li>
									<li><a href="#">Website Builder</a></li>
								</ul>
							</section>
							<section class="3u 6u(medium) 12u$(small)">
								<h3>Location</h3>
								<ul class="unstyled">
									<li><a>LDRP-ITR,</a></li>
									<li><a>Sector-15,Near Kh-5,</a></li>
									<li><a>Gandhinagar,</a></li>
									<li><a>Gujarat.</a></li>
								</ul>
							</section>
							<section class="3u$ 6u$(medium) 12u$(small)">
								<h3>Contact Us</h3>
								<ul class="unstyled">
									<li><a>mail@onlineshopmaker.dx.am</a></li>
									<li><a>(+91)9427606780</a></li>
									<li><a>(+91)9408640023</a></li>
								</ul>
							</section>
							</div>
					</section>
					<div class="row">
						<div class="8u 12u$(medium)">
							<ul class="copyright">
								<li>&copy; Online Shop Maker. All rights reserved.</li>
								<li>Design & Images: <a href="#">Online Shop Maker</a></li>
							</ul>
						</div>
						<div class="4u$ 12u$(medium)">
							<ul class="icons">
								<li>
									<a class="icon rounded fa-facebook"><span class="label">Facebook</span></a>
								</li>
								<li>
									<a class="icon rounded fa-twitter"><span class="label">Twitter</span></a>
								</li>
								<li>
									<a class="icon rounded fa-google-plus"><span class="label">Google+</span></a>
								</li>
								<li>
									<a class="icon rounded fa-linkedin"><span class="label">LinkedIn</span></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</footer>
					
					
							<?php  
if(!isset($_SESSION["username"])){
	echo '<script language="javascript">
	alert("You need to Sign In to use this feature!!!")
	window.location.href="login.php"
	</script>';
}
?>
