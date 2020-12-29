<?php
	require '../config/config.php';
	$_SESSION['page'] = "Home";
	// $passwordInput = hash("sha256", "test123");
	// echo $passwordInput;
	// echo "<hr><pre>";
	// var_dump($_SESSION);
	// echo "</pre>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home | Dentō Dojo</title>
	<link rel="icon" href="../images/icon.png">
	<script src="https://kit.fontawesome.com/0a28ed80d2.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../style.css">
	<style>
		@keyframes rainbow{
			0%{
				color: red;
				transform: scale(1);
			}
			10%{
				color: orange;
				transform: scale(1.1);
			}
			20%{
				color: yellow;
				transform: scale(1);
			}
			30%{
				color: green;
				transform: scale(1.1);
			}
			40%{
				color: blue;
				transform: scale(1);
			}
			50%{
				color: purple;
				transform: scale(1.1);
			}
			100%{
				color: red;
				transform: scale(1);
			}
		}
		#login-form h1{
			animation: rainbow 7s infinite forwards;
		}
	</style>
</head>
<body id="home">
	<!-- Webpage -->
	<div id="page-container">
		<div id="content-wrap">
			<!-- Navbar -->
			<?php require '../nav.php';?>

			<?php require '../login/login-banner.php';?>

			<?php if(!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']):?>
			<!-- Login Form -->
			<form id="login-form" action="../login/login.php" method="POST">
				<h1 class="responsive-title text-center mt-2">Welcome to Dentō Dojo!</h1>
				<div class="container">
					<div class="row mb-3 pt-3">
						<div class="col-12 text-center">
							<input id="email-input" name="email" type="email" placeholder="Email">
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-12 text-center">
							<input id="password-input" name="password" type="password" placeholder="Password">
						</div>
					</div>
					<?php if(isset($_SESSION['login_error']) && !empty($_SESSION['login_error'])):?>
					<div id="error-row" class="row mb-3">
						<div id="error-message" class="col-12 text-center text-danger">
							<?php echo $_SESSION['login_error'];?>
							<?php unset($_SESSION['login_error']);?>
						</div>
					</div>
					<?php else:?>
					<div id="error-row" class="row mb-3">
						<div id="error-message" class="col-12 text-center text-danger">
						</div>
					</div>
					<?php endif;?>
					<div class="row mb-2">
						<div class="col-12 text-center">
							<input class="btn btn-primary text-light" type="submit" value="Log in"> 
						</div>
					</div>
					<div class="row">
						<div class="text-light col-12 text-center mb-2">
							Interested in joining? <br/><span><a href="register.php">Click here</a></span>
						</div>
					</div>
				</div>
			</form>
			<?php else:?>
			<div id="login-form">
				<h1 class="responsive-title text-center text-light mt-2">Welcome back <?php echo $_SESSION['user'];?>!</h1>
				<?php if($_SESSION['user'] == "Sensei"):?>
				<span class="text-light pl-4">Through the Online Dojo you can:</span>
				<ul class="text-light pl-5 pr-2">
					<li>View, add, edit, or delete classes in the Schedule tab</li>
					<li>View or post an announcement in the Announcements tab</li>
					<li>Read about Senseis in the Senseis tab</li>
					<li>Log Out by clicking the Log Out tab</li>
				</ul>
				<?php elseif($_SESSION['user'] == "Student"):?>
				<span class="text-light pl-4">Through the Online Dojo you can:</span>
				<ul class="text-light pl-5 pr-2">
					<li>View, join, or drop classes in the Schedule tab</li>
					<li>View announcements in the Announcements tab</li>
					<li>Read about Senseis in the Senseis tab</li>
					<li>Log Out by clicking the Log Out tab</li>
				</ul>
				<?php endif;?>
			</div>
			<?php endif;?>
		</div>
		
		<!-- Footer -->
		<div class="text-light bg-dark text-center" id="footer">
			© 2020 Dentō Dojo
		</div>
	</div>
	<?php if(!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']):?>
	<!-- Validation -->
	<script src="../javascript/login_validation.js"></script>
	<!-- Other scripts -->
	<?php endif;?>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>