<?php
	require '../config/config.php';
	$_SESSION['page'] = "Register";
	if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']){
		header("Location: index.php");
		exit();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register | Dentō Dojo</title>
	<link rel="icon" href="../images/icon.png">
	<script src="https://kit.fontawesome.com/0a28ed80d2.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
	<!-- Webpage -->
	<div id="page-container">
		<div id="content-wrap">
			<!-- Navbar -->
			<?php require '../nav.php';?>

			<!-- Heading -->
			<h1 class="text-center title-color mt-5 mb-5">Registration - Coming Soon</h1>
			<p class="text-center">This website is still under testing. Unfortunately, we are not able to register new students online at this time. Please come back later or call us at (123) 456-7890 to do it via the phone. Thank you!</p>

		</div>
		
		<!-- Footer -->
		<div class="text-light bg-dark text-center" id="footer">
			© 2020 Dentō Dojo
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>