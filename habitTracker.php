
<?php
	session_start();
	date_default_timezone_set('US/Eastern');
	//echo date_default_timezone_get();
	// cool way of getting May 3, 2019, 9.27pm
	//date("F j, Y, g:i a");
    $current_date = date("F j, Y");
    // this is the date format we will use to insert into the Database
    $date_entry_db = date("Y-m-d");
   
    $servername = "moneytalksdb.cckunwkryewb.us-east-2.rds.amazonaws.com:3306";//server name
    $name = "moneytalksdb";//server username
    $servpass = "password";//server password


	if(isset($_POST["check"]))
		$_SESSION["check"] = $_POST["check"];
	
	$depositCheck = false;
	
	$month = substr($date_entry_db, 0, 7);
	
	
	$conn = mysqli_connect('moneytalksdb.clagfj0kucyy.us-east-1.rds.amazonaws.com', 'admin', 'dontthinktwice', 'moneytalks', '3306');
	//$db = mysqli_select_db($conn, "moneytalks");
	if(isset($_POST["depositAmount"]))
		$amount = $_POST["depositAmount"];
	else
		$amount = 0;
	
	if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
	}
	
	$query1 = 'SELECT * FROM HABIT where username = "' . $_SESSION["username"] . '" and date = "' . $date_entry_db . '"';//Can be used to check if the user has input the wrong info and already deposited.
	$query2 = "INSERT INTO HABIT(username, date, amount) VALUES (" . '"' . $_SESSION["username"] . '","' . $date_entry_db . '", ' . $amount . ')';//Will insert the deposit information into the table. Update $amount to the amount the user has deposited in order to insert a value other than 0 in the amount tuple.  
	$query3 = 'SELECT COUNT(*) as count FROM HABIT where username = "' . $_SESSION["username"] . '" and date like "' . $month . '%"';//Will return the count(amount of times the user has deposited) as total. 
	$query4 = 'SELECT SUM(amount) as sum FROM HABIT where username = "' . $_SESSION["username"] . '" and date like "' . $month . '%"';//Will return the count(amount of times the user has deposited) as total. 
	
	
	/*
	The general format of this if else is used to get the results of the query. If you want the count, use similar format, but use
	if(mysqli_num_rows($result) > 0){
		$count = mysqli_fetch_assoc($result);
	else
		the user hasn't deposited at all
	use $count["total"] to access the actual amount of times the user has deposited. If you have any questions, let me know. 
	if(isset($_POST["check"])){ Can be used to check is the radio buttons have been used
		if(strcmp($_POST["check"], "yes") == 0){//will check if the radio button is yes
			$result = mysqli_query($conn, $query1);//The query results
							 
			if(mysqli_num_rows($result) == 0)//Check if anything is returned.
				mysqli_query($conn, $query2);
			else
				mysqli_query($conn, $query2);
		}
	}
	*/
	$result = mysqli_query($conn, $query1);
	if(mysqli_num_rows($result) > 0){
		$depositCheck = true;
	}
	
	if(isset($_POST["depositAmount"])){
		mysqli_query($conn, $query2);
	}
	
	$result1 = mysqli_query($conn, $query3);
	$result2 = mysqli_query($conn, $query4);
	$row1 = mysqli_fetch_assoc($result1);
	$row2 = mysqli_fetch_assoc($result2);
		
	$count = $row1["count"];
	
	if($count > 0)
		$total = $row2["sum"];
	else
		$total = 0;
		
 

	mysqli_close($conn);
?>
<head>
    <title>MONEYTALK$ || HABIT TRACKER</title>
    <link rel="sytlesheet" href="style.css">
    <link type="text/css" rel="stylesheet" href="stylesheet.css"/>
	 <link type="text/css" rel="stylesheet" href="styleforhabits.css"/>
</head>
    <body>
            <div class="navigation">
                <nav>
                    <ul>
                        <li class="home"><a class="links" href="homepage.php">MONEYTALK$</a></li>
                        <li><a class="links" href="login-page.php">Log Out</a></li>
						<li><a class="links" href="habitTracker.php">Habit Tracker</a></li>
                        <li><a class="links" href="investing.html">Investing</a></li>
                        <li><a class="links" href="goalsCalc.html">Goals Calc</a></li>
                    </ul>
                </nav>
            </div><!--NAVIGATION BAR-->
        
        
        <p class="motivational"><q>DO NOT SAVE WHAT IS LEFT AFTER SPENDING, BUT SPEND WHAT IS LEFT AFTER SAVING.</q> <br>
		<span id="quotefont"><i>-Warren Buffet</i></span></p>
        
        <div class="Calendar">
		
		
		<?php
			if(!isset($_SESSION["check"])){
		?>
				<form action="" method="POST">

				<h1><?= $current_date?></h1>
					<label><p>Did you deposit today</p></label>
					<input type="radio" name = "check" value="yes" checked>YES
					<input type="radio" name = "check" value="no">NO <br>
					<input type = "submit"/>
				</form>
		
			<?php
					
			}
			else if($depositCheck && !isset($_POST["HabitCheck"]) && !isset($_POST["goalAmount"])){
				
			?>
				<form action="" method="POST">

				<h1>Records already exist for <?= $current_date?></h1>
					<label><p>Would you like to input goal?</p></label>
					<input type="radio" name = "HabitCheck" value="yes" checked>YES
					<input type="radio" name = "HabitCheck" value="no">NO <br>
					<input type = "submit"/>
				</form>
		
			<?php
				
			}
			else{ 
				if(isset($_POST["check"]) && strcmp($_SESSION["check"], "yes") == 0 && !isset($_POST["amount"])){
			?>
				<form action="" method="POST">
					<h1><?= $current_date?></h1>
					<label><p>How much did you Deposit Today?</p></label>
					<input type="number" id="deposit" name="depositAmount" min="10">
				
					<input type = "submit"/>
				</form>
				<?php
				}
				else if(isset($_POST["check"]) && strcmp($_SESSION["check"], "no") == 0 && !isset($_POST["amount"])){
					?>
					<form action="" method="POST">

					<h1>Welcome to the Habit Tracker!</h1>
						<label><p>Would you like to input your goal?</p></label>
						<input type="radio" name = "HabitCheck" value="yes" checked>YES
						<input type="radio" name = "HabitCheck" value="no">NO <br>
						<input type = "submit"/>
					</form>
				<?php
				}
				else if((isset($_POST["depositAmount"]) || isset($_POST["HabitCheck"])) && !isset($_POST["goalAmount"])){
					if(strcmp($_POST["HabitCheck"], "yes") == 0){
				?>
						<form action="" method="POST">
						<h1>Welcome to the Habit Tracker!</h1>
						<label><p>What is your goal?</p></label>
						<input type="number" id="deposit" name="goalAmount" min="10">
						<input type = "submit"/>
					</form>
					
				<?php
					}
					else{
					unset($_SESSION["check"]);
				?>
					<div class = "habit">
					<h1 class = "outputHeader">Welcome to the Habit Tracker!</h1>
					<?php
						if($count == 0){
					?>		
							<p class = "output">Sorry!!! You haven't deposited anything this month!!!</p> <br/> <br/>
							<p class = "output"><a href = "homePage.php">Click here or the MONEYTALK$ logo to return to home page!</a></p>
					<?php
						}
						else{
					?>
						<p class = "output">You have deposited <?=$count?> time(s) this month.</p>
						<p class = "output">You have deposited $<?=$total?> this month. Keep up the great work!!!!!</p><br/><br/>
						<p class = "output"><a href = "homePage.php">Click here or the MONEYTALK$ logo to return to home page!</a></p>
				</div>
				
				<?php
						}
					}
				}
				
			
				else if(isset($_POST["goalAmount"])){
					unset($_SESSION["check"]);
				?>
				<div class = "habit">
					<h1 class = "outputHeader">Welcome to the Habit Tracker!</h1>
					<p class = "output">Your goal was $<?=$_POST["goalAmount"]?></p>
					<p class = "output">You have deposited <?=$count?> time(s) this month.</p>
					<p class = "output">You have deposited $<?=$total?> this month.</p>
					<?php
						if($total == $_POST["goalAmount"]){
					?>		
							<p class = "output">Congratulations!!! You have met your goal of $<?=$_POST["goalAmount"]?>!!!!</p> </br> </br>
							<p class = "output"><a href = "homePage.php">Click here or the MONEYTALK$ logo to return to home page!</a></p>
					<?php
						}
						else if($total > $_POST["goalAmount"]){
							$difference = $total - $_POST["goalAmount"];
					?>		
							<p class = "output">Congratulations!!! You have exceeded your goal of $<?=$_POST["goalAmount"]?> by $<?=$difference?>!!!! Great Job!!!!</p>  </br> </br>
							<p class = "output"><a href = "homePage.php">Click here or the MONEYTALK$ logo to return to home page!</a></p>
					<?php
						}
						else{
							$difference = $_POST["goalAmount"] - $total;
					?>
						<p class = "output">You still have  $<?=$difference?> to reach your goal of $<?=$_POST["goalAmount"]?>. Don't Give Up!!!!!</p>  </br> </br>
						<p class = "output"><a href = "homePage.php">Click here or the MONEYTALK$ logo to return to home page!</a></p>
				<?php
					}
				}
			}
			
			
	
			
			
			
					
			?>

				
				
				
			</div>
        
        </div>
		<footer>
			<p>Copyright 2019 Eduardo, Esau, Lilybeth Website</p>
			</footer>
    </body>
