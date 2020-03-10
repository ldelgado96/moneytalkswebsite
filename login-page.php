<!--Author: Esau Cuellar
	Course: Web Programming
	Description: Name of database is moneytalks, table is PROFILES-->
<?php
	session_start();
	
	if(isset($_SESSION["username"])){
		session_unset();
		session_destroy();
		session_start();
	}
    $servername = "moneytalksdb.cckunwkryewb.us-east-2.rds.amazonaws.com:3306";//server name
    $name = "moneytalksdb";//server username
    $servpass = "password";//server password

	
	$conn = mysqli_connect($servername, $name, $servpass);
	$db = mysqli_select_db($conn, "moneytalks");
	
	$conn = mysqli_connect('moneytalksdb.clagfj0kucyy.us-east-1.rds.amazonaws.com', 'admin', 'dontthinktwice', 'moneytalks', '3306');
	
	if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";
	
	$query1 = 'SELECT username, password FROM PROFILES';
	if(isset($_POST["nickname"])){
		$query2 = "INSERT INTO PROFILES (username, password, email) VALUES (" . '"' . $_POST["nickname"] . '","' . $_POST["newpassword"] . '", "' . $_POST["email"] . '")';
		//echo $query2;
	}
	//echo $query1;
	
	$check = false;
	$usercheck = false;
	$passcheck = false;
	
	if(isset($_POST["username"])){
		$result = mysqli_query($conn, $query1);
							 
			if(mysqli_num_rows($result) > 0){
				 while($row = mysqli_fetch_assoc($result)){
					if(strcmp($_POST["username"], $row["username"]) == 0 && strcmp($_POST["password"], $row["password"]) == 0)
					 $check = true;
				 
					if($check){
					$username = $_POST["username"];
					$_SESSION["username"] = $username; 
					header("Location:homePage.php");
					
					exit;
				}
					}
			}
							 
	}

		if(isset($_POST["nickname"])){
			$user_pass_check = preg_match('/^\S{6,}\z/', $_POST["nickname"]) && preg_match('/^\S{6,}\z/', $_POST["newpassword"]);
			$result = mysqli_query($conn, $query1);
			$check = false;
			
			if(strcmp($_POST["newpassword"], $_POST["conpassword"]) == 0){
				$passcheck = true;
			}
			
			
			while($row = mysqli_fetch_assoc($result)){
				if(strcmp($_POST["nickname"], $row["username"]) == 0){
					$usercheck = true;
				}
			}
			if(!$usercheck && $passcheck && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) && $user_pass_check){
				mysqli_query($conn, $query2);
			}
		}
				
			
  		
	mysqli_close($conn);
	
	
?>
<!DOCTYPE html>
<html lang = "en">
	<head>
		<title>MONEYTALK$ || SIGN UP/LOGIN</title>
		<link href = "??????" type = "image/gif" rel = "shortcut icon"/><!-- ???? = Favicon name -->
		<meta charset="utf-8" />
		<link href="stylesheet.css" type="text/css" rel="stylesheet" /><!-- ???? = Stylesheet name -->
		<link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js" type="text/javascript" />
		<link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.css" type="text/css" rel="stylesheet" />
	</head>

	<body>
		<div class = "navigation">
			<nav>
				<ul>
				<form action = "" name = "login[]" id = "login" method = "post">
					<li class="home"><a class="links" href="homepage.php">MONEYTALK$</a></li>
					<div class="float-right">
						<label>USERNAME </label>
						<input type = "text" name = "username" size = "16" autofocus = "autofocus" required = "required"/> 
						<label>PASSWORD </label>
						<input type = "password" name = "password" size = "16" required = "required"/> 
						<input type = "submit" value = "Log In"/>
					</div>
					
					<?php
						if(isset($_POST["username"]) && !$check){
						?>
					<br/> <br/> <p class = "Error">Username and password do not match our records. Try again or sign up below.</p>
					<?php
						}
					?>
				</form>
				</ul>
			</nav>
		</div>
		
		
		
		<div class = "signup" style="float:right; padding:30px; background-color: antiquewhite; margin-right: 20px; margin-top: 30px;">
			<form action = "" name = "signup[]" id = "signup" method = "post">
				<fieldset>
				<?php
					if(isset($_POST["nickname"]) && !$passcheck){?>
					<label>EMAIL </label>
					<input type = "text" name = "email" size = "16" required = "required" value = <?=$_POST["email"]?>/> <br/> <br/>
					<label>USERNAME </label>
					<input type = "text" name = "nickname" size = "16" required = "required" value = <?=$_POST["nickname"]?>/> <br/> <br/>
					<?php
					}
					else{?>
						<label>EMAIL </label>
						<input type = "text" name = "email" size = "16" required = "required"/> <br/> <br/>
						<label>USERNAME </label>
						<input type = "text" name = "nickname" size = "16" required = "required"/> <br/> <br/>
					<?php
					}
					?>
					<label>PASSWORD </label>
					<input type = "password" name = "newpassword" size = "16" autofocus = "autofocus" required = "required"/> <br/> <br/>
					<label>CONFIRM PASSWORD </label>
					<input type = "password" name = "conpassword" size = "16" required = "required"/> <br/> <br/>
					<?php
					if(isset($_POST["nickname"])){
						if($usercheck){
					?>
							<p class = "Error">Warning: Username already taken.</p>
					<?php
						}
						else if(!$passcheck){?>
							<p class = "Error">Warning: Password does not match with confirmation.</p>
					<?php
						}
						else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){?>
							<p class = "Error">Warning: Please input a valid email address.</p>
					<?php
						}
						else if(!$user_pass_check){
					?>						
						<p class = "Error">Warning: Username/Password must contain 6 characters or more, and must contain no whitespaces.</p>
					<?php
						}
						else{
					?>
							<p>Congratulations! Account Created Successfully! Login in above to use MoneyTalk$!!!</p>
					<?php
						}
					}
					?>
					<input type = "submit" value = "Submit"/>
				</fieldset>
			</form>
		</div>

		<p><img src="homeimg.jpeg" alt = "moneytalks" width="450px" height="450px" style=" position: absolute; left: 30px; margin:0px; padding:25px;"/></p>
		
		
		</body>
	
</html>
