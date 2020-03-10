<?php
	session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>MONEYTALK$ || HOME</title>
        <link type="text/css" rel="stylesheet" href="stylesheet.css"/>
		<link type="text/css" rel="stylesheet" href="homepageStyle.css"/>
        <script>
           //alert("testing.")
        </script>
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
            
      <!--ABOUT-->
		
		
			<div id="informationContainer">
			<div id="tableRow">
			
				<div id="mainInformation">
					<p>
							<?php
								if(isset($_SESSION["username"])){
							?>
								
								<h2 class="welcome">Welcome <?=$_SESSION["username"];?>!</h2>
								<p> Brief Introduction!</p>
								<?php
								
								}
								else
								{
							?>
									<h2 class="welcome">Not logged in! Please log in or create account on the login page to enjoy MoneyTalk$!</p>
							<?php
								}
							?>
					</p>
				
				</div>
				<div id="mainInformation2">
				
					<p>
						<p>This page is here to help you understand how long it will take to reach your goal!</p>
						<div>
							<h3>How to use the goals calculator?</h3>
							<ol>
								<li><span class="list-numbers">1. </span>Let's first attach a goal to your savings.</li>
								<li><span class="list-numbers">2. </span>Add a parameter of how much you want to save.</li>
								<li><span class="list-numbers">3. </span>Also, amount of time you wish to do this.</li>
							</ol>
						</div>
					</p>
					
				</div>
			
			</div>
			
			</div>
				<h1 class="devTitle">DEVELOPERS</h1>
			<div class= "picRow">
			
					<p class="picleft">
						<img src="iconImages/boyIcon.png" alt="Eduardo">
					</p>
					
					<p class="middleSec">
					
						<img src="iconImages/femaleicon.jpg" alt="Lilybeth">
					</p>
					
					<p class="picRight">
						<img src="iconImages/boyIcon.png" alt="Esau">
					</p>
				
			</div>

			<div class="developers">
			
			<p>Eduardo</p>
			<p>Lilybeth</p>
			<p>Esau</p>
			
			</div>
			
		
		<footer>
			<p>Copyright 2019 Eduardo, Esau, Lilybeth Website</p>
			</footer>
		
    </body>
</html>

