<?php session_start(); ?>
<!DOCTYPE html>

<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Online Shop Maker</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<script src="js/myjs.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>

	<script>
		function showResult(str) {
		  if (str.length==0) { 
		    document.getElementById("show_product").innerHTML="";
		    document.getElementById("show_product").style.border="0px";
		    return;
		  }
		  if (window.XMLHttpRequest) {
		    // code for IE7+, Firefox, Chrome, Opera, Safari
		    xmlhttp=new XMLHttpRequest();
		  } else {  // code for IE6, IE5
		    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  xmlhttp.onreadystatechange=function() {
		    if (this.readyState==4 && this.status==200) {
		      document.getElementById("show_product").innerHTML=this.responseText;
		      document.getElementById("show_product").style.border="1px solid #A5ACB2";
		    }
		  }
		  xmlhttp.open("GET","search_delete_product-admin.php?q="+str,true);
		  xmlhttp.send();
		}

		function showResult_cat(choice,str) {
		  if (str.length==0) { 
		    document.getElementById("show_product_cat").innerHTML="";
		    document.getElementById("show_product_cat").style.border="0px";
		    return;
		  }
		  if (window.XMLHttpRequest) {
		    // code for IE7+, Firefox, Chrome, Opera, Safari
		    xmlhttp=new XMLHttpRequest();
		  } else {  // code for IE6, IE5
		    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  xmlhttp.onreadystatechange=function() {
		    if (this.readyState==4 && this.status==200) {
		      document.getElementById("show_product_cat").innerHTML=this.responseText;
		      document.getElementById("show_product_cat").style.border="1px solid #A5ACB2";
		    }
		  }
		  xmlhttp.open("GET","search_delete_product-admin.php?q="+str+"&c="+choice,true);
		  xmlhttp.send();
		}

		function showResult_subcat(choice,sub_choice,str) {
		  if (str.length==0) { 
		    document.getElementById("show_product_subcat").innerHTML="";
		    document.getElementById("show_product_subcat").style.border="0px";
		    return;
		  }
		  if (window.XMLHttpRequest) {
		    // code for IE7+, Firefox, Chrome, Opera, Safari
		    xmlhttp=new XMLHttpRequest();
		  } else {  // code for IE6, IE5
		    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  xmlhttp.onreadystatechange=function() {
		    if (this.readyState==4 && this.status==200) {
		      document.getElementById("show_product_subcat").innerHTML=this.responseText;
		      document.getElementById("show_product_subcat").style.border="1px solid #A5ACB2";
		    }
		  }
		  xmlhttp.open("GET","search_delete_product-admin.php?q="+str+"&c="+choice+"&s="+sub_choice,true);
		  xmlhttp.send();
		}

		function change(){
			if (document.getElementById('choice').value == 'by_product_only'){
				document.getElementById('by_product_name').style.display='block';
				document.getElementById('by_category').style.display='none';
				document.getElementById('by_subcategory').style.display='none';
			}
			else if (document.getElementById('choice').value == 'by_category'){
				document.getElementById('by_product_name').style.display='none';
				document.getElementById('by_category').style.display='block';
				document.getElementById('by_subcategory').style.display='none';
			}
			else{
				document.getElementById('by_product_name').style.display='none';
				document.getElementById('by_category').style.display='none';
				document.getElementById('by_subcategory').style.display='block';
			}
		}

		function get_choice(){
			var choice = document.getElementById('choice_category').value;
			document.getElementById('temp_cat_choice').value = choice;
		}

		function confirm_action(){
			var con = confirm("Are you sure want to delete this product? YOU CAN NOT UNDO THIS ACTION LATER!");
			if (con == true){
				document.delete-form.submit();
			}
			else{
				event.preventDefault();
			}
		}
	</script>

	</head>
	<body>
	<!-- Header -->

			<!--Main section-->
			<section id="main" class="wrapper">
				<div class="container">
					<h2 style="color:blue">Product entry summary (Select product to delete)</h2>
					<br>

					<?php
						$file = fopen("user_folders/".$_SESSION['username']."/product_data.json", 'r');
						if (filesize("user_folders/".$_SESSION['username']."/product_data.json") == 0){
							echo "<h3>You have not entered any products till now!!!</h3>";
						}
						else{
							$file_read = fread($file, filesize("user_folders/".$_SESSION['username']."/product_data.json"));
							$json_array = json_decode($file_read, true);
							foreach ($json_array as $key => $value) {
								$_SESSION['shop_name'] = $key;
							}
							if (count($json_array[$_SESSION['shop_name']]) == 0){
								echo "<h3>You have not entered any products till now!!!</h3>";
							}
							else{
								$count_cat = 0;  // category count
								$count_subcat = 0;  // subcategory count
								$count_pro = 0;  // product count
								$list = [];  // list format => [product_category, product_subcategory, product_name]
								$unique_cat = ['']; // to use in drop down
								$unique_subcat = [['','']]; // to use in drop down
								$choice_to_fill = [];
								foreach ($json_array[$_SESSION['shop_name']] as $key=>$value) {
									$count_cat++;
									array_push($unique_cat, $key);
									foreach ($value as $key1 => $value1) {
										$count_subcat++;
										array_push($unique_subcat, [$key, $key1]);
										foreach ($value1 as $key2 => $value2) {
											$count_pro++;
											$list_names = [];
											array_push($list_names, $key);  // product category
											array_push($list_names, $key1);  // product subcategory
											array_push($list_names, $key2);  // product name
											array_push($list, $list_names);
										}
									}
								}
								$_SESSION["names"] = $list;
								?>

								<strong>Select your 'search by' choice:</strong>
								<div id="options" class="3u 6u$(4)">
									<select id="choice" onchange="change();">
										<option value="by_product_only">direct product name search</option>
										<option value="by_category">category specific products</option>
										<option value="by_subcategory">subcategory specific products</option>
									</select>
								</div>

								<div align="left" id="by_product_name" style="display: block;">
									<div class="3u 6u$(4)">
										<br><strong>Search by product name: </strong>
										<div align="left">
										 <input type="text" id="search_product" name="search_product" onkeyup="showResult(this.value);">
										 	<div id="show_product"></div>
										 </div>
									</div>
								</div>

								<div id="by_category" style="display: none;" class="3u 6u$(4)">
									<br><strong>select category(will appear only if you have entered data for same)</strong>
									<select id="choice_category" onchange="get_choice();">
										<?php
											foreach ($unique_cat as $key => $value) {
												echo "<option value='".$value."'>".$value."</option>";	
											}
										?>
									</select>
									<input type="hidden" id="temp_cat_choice">
									<br><strong>Product name</strong>
									<input type="text" id="search_product" name="search_product" onkeyup="showResult_cat(document.getElementById('temp_cat_choice').value,this.value);">
									<div id="show_product_cat"></div>
								</div>

								<script>
									var choices = new Array();
									var i = 0;

									<?php foreach ($unique_subcat as $value) { ?>
											var temp = [];
											temp.push('<?php echo $value[0]; ?>');
											temp.push('<?php echo $value[1]; ?>');
											choices.push(temp);
											//console.log(choices);
											i++;
											//document.write(choices);
									<?php }  ?>

									function get_choice_sub(){
										var selected_cat = document.getElementById('choice_subcategory').value;	
										removeAllOptions(document.temp_form.fill_subcategory_choices);

										for (var j=0; j<choices.length; j++){
											if (selected_cat == choices[j][0]){
												addOption(document.temp_form.fill_subcategory_choices, choices[j][1], choices[j][1]);
											}
										}
									}

									function addOption(selectbox, value, text )
									{
										var optn = document.createElement("OPTION");
										optn.text = text;
										optn.value = value;

										selectbox.options.add(optn);
									}

									function removeAllOptions(selectbox)
									{
										var i;
										for(i=selectbox.options.length-1;i>=0;i--)
										{
												//selectbox.options.remove(i);
												selectbox.remove(i);
										}
									}

									function set_subcategory(){
										var temp_cat_name = document.getElementById('choice_subcategory').value;
										var temp_subcat_name = document.getElementById('fill_subcategory_choices').value;
										document.getElementById('temp_cat_choice_sub').value = temp_cat_name;
										document.getElementById('temp_subcat_choice_sub').value = temp_subcat_name;
									}
								</script>


								<div id="by_subcategory" style="display: none;" class="3u 6u$(4)">
									<br><strong>select category(will appear only if you have entered data for same)</strong>
									<select id="choice_subcategory" onchange="get_choice_sub();">
										<?php
											foreach ($unique_cat as $key => $value) {
												echo "<option value='".$value."''>".$value."</option>";	
											}
										?>
									</select>
									<br><strong>select subcategory(will appear only if you have entered data for same)</strong>
									<form name="temp_form">
									<select id="fill_subcategory_choices" name="fill_subcategory_choices" onchange="set_subcategory();">
									</select>
									</form>
									<input type="hidden" id="temp_cat_choice_sub">
									<input type="hidden" id="temp_subcat_choice_sub">
									<br><strong>Product name</strong>
									<input type="text" id="search_product" name="search_product" onkeyup="showResult_subcat(document.getElementById('choice_subcategory').value,document.getElementById('fill_subcategory_choices').value,this.value);">
									<div id="show_product_subcat"></div>
								</div>
						
								<?php

								if (isset($_GET["pro"])){
									$got_name = $_GET["pro"];
									$got_id = $_GET["i"];
									if ($got_name != ""){
										echo "<br><br><h4>Showing data for product name: ".$got_name."</h4>";
										$data_to_show = $json_array[$_SESSION['shop_name']][$list[$got_id][0]][$list[$got_id][1]][$got_name];
										echo "<br>Product category: ".$list[$got_id][0];
										echo "<br>Product subcategory: ".$list[$got_id][1];
										foreach ($data_to_show as $key => $value) {
											if ($key != "product_image")
												if ($value != "")
													echo "<br>".$key.": ".$value;
												else
													echo "<br>".$key.": Not specified";
											else{
												echo "<br>product_image<br>";
												for ($j=0; $j<count($value); $j++){
												?>
													<div style="position: relative; display: inline-block;">
													<br><img alt="Image could not be loaded" width="200" height="300" src="<?php echo 'user_folders/'.$_SESSION['username'].'/images/'.$value[$j]; ?>" border="5"/>
													</div>
												<?php
												}
											}
										}
										?>
											<form method="post" action="delete-product-code-admin.php" name="delete-form" id="delete-form">
												<input type="hidden" id="product_name" name="product_name" value="<?php echo $got_name ?>">
												<input type="hidden" id="product_cat" name="product_cat" value="<?php echo $list[$got_id][0] ?>">
												<input type="hidden" id="product_subcat" name="product_subcat" value="<?php echo $list[$got_id][1] ?>">
												<input type="hidden" id="product_id" name="product_id" value="<?php echo $data_to_show['product_id'] ?>">
												<button onclick="confirm_action();">delete this product</button>
											</form>
											<?php
									}
								?>
								<script>    
    								if(typeof window.history.pushState == 'function') {
        							window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
    								}
									</script>
								<?php
								}
							}
						}
					?>

				</div>
			</section>

			<!-- Footer -->
			
	</body>

</html>