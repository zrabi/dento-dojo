<?php
	require '../config/config.php';
	$_SESSION['page'] = "Senseis";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Senseis | Dentō Dojo</title>
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

			<?php require '../login/login-banner.php';?>

			<!-- Heading -->
			<h1 class="text-center title-color mt-5 mb-5">Senseis</h1>

			<!-- Senseis -->
			<div class="container text-center" id="senseis-table">
				<div class="row">
					<div class="col-12 col-md-5 mr-auto mb-2">
						<img class="rounded-circle img-fluid mx auto" src="../images/sensei1.jpg" alt="Sensei 1">
						<h3 class="title-color">Sensei Rueben Lim</h3>
						<h5 class="subtitle-color">2nd Dan</h5>
						<p>Sensei Lim started practicing traditonal Shotokan Karate in 2001. He founded Dentō Dojo after moving to California from Vietnam in 2015. Since then, he transformed Dentō Dojo to a respected and well-recognized Karate club.</p>
					</div>
					<div class="col-12 col-md-5 ml-auto mb-2">
						<img class="rounded-circle img-fluid mx auto" src="../images/sensei2.jpg" alt="Sensei 2">
						<h3 class="title-color">Sensei Elisa Chang</h3>
						<h5 class="subtitle-color">1st Dan</h5>
						<p>Sensei Chang started practicing Karate in 2008. She joined Dentō Dojo in 2016. Other than teaching classes, she is also a respected internatioal Karate referee.</p>
					</div>
				</div>
			</div>
		</div>

		<!-- Footer -->
		<div class="text-light bg-dark text-center" id="footer">
			© 2020 Dentō Dojo
		</div>
	</div>
	<script>
		let images = document.querySelectorAll("img");
		for (let i = 0; i < images.length; i++){
			console.log(images[i])
			images[i].onmouseleave = function(){
				this.style.width = "75%";
				this.style.border = "none";
			}
			images[i].onmouseenter = function(){
				this.style.width = "85%";
				this.style.border = "5px solid #8C2025";
			}
		}
	</script>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>