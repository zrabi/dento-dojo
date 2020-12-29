<?php
	require '../config/config.php';
	$_SESSION['page'] = "Announcements";

	// Need to parse out the page parameter
	$page_url = preg_replace('/&page=\d*/', '', $_SERVER['REQUEST_URI']);

	// Establish connection to DB
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if($mysqli->connect_errno){
		echo $mysqli->connect_error;
		exit();
	}
	$mysqli->set_charset('utf8');

	$sql = "SELECT COUNT(*) AS count FROM announcements;";
	$results = $mysqli->query($sql);
	if(!$results){
		echo $mysqli->error;
		exit();
	}

	// Display results on the Website - done below

	// Pagination
	$results_per_page = 3;
	$first_page = 1;

	// Get the result (count)
	$row = $results->fetch_assoc();
	$num_results = $row['count'];

	$last_page = ceil($num_results / $results_per_page);

	// Current page?
	if(isset($_GET['page']) && !empty($_GET['page'])) {
		$current_page = $_GET['page'];
	}
	else {
		$current_page = $first_page;
	}

	// Out of bounds error checking 
	if($current_page < $first_page) {
		$current_page = $first_page;
	}
	elseif($current_page > $last_page) {
		$current_page = $last_page;
	}

	$previous_page = $current_page - 1;
	$next_page = $current_page + 1;

	if($previous_page < $first_page){
		$previous_page = $first_page;
	}
	if($next_page > $last_page){
		$next_page = $last_page;
	}

	// Start index
	$start_index = ($current_page - 1) * $results_per_page;

	// SQL Query - No need to prepare here
	$sql = "SELECT * FROM announcements ORDER BY id DESC LIMIT ".$start_index.", ".$results_per_page.";";
	$results = $mysqli->query($sql);
	if(!$results){
		echo $mysqli->error;
		exit();
	}

	// Close connection
	$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Announcements | Dentō Dojo</title>
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

			<?php if(isset($_SESSION['user']) && $_SESSION['user'] == "Sensei"):?>
			<!-- New Announcement Form-->
			<form id="announ-form" method="POST" action="../post_announcement.php">
				<h1 class="text-center title-color mt-5 mb-5">Post a New Announcement</h1>
				<div class="container">
					<div class="row">
						<div class="col-md-6 col-12">
							<div class="form-group">
								<label for="new-announ-title"><span class="text-danger">*</span>New Announcement's Title:</label>
								<input id="announ-form-title" type="text" name="title" aria-describedby="title-help" class="form-control" placeholder="Enter title">
								<small id="title-help" class="form-text text-muted">*required field, max 100 characters</small>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label for="new-announ-text"><span class="text-danger">*</span>New Announcement's Text:</label>
								<textarea id="announ-form-text" name="text" aria-describedby="text-help" placeholder="Enter text" class="form-control" id="new-announ-text" rows="3"></textarea>
								<small id="text-help" class="form-text text-muted">*required field, max 400 characters</small>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<button type="submit" class="btn btn-primary">Post</button>
							<input class="btn btn-secondary" type="reset" value="Reset">
						</div>
					</div>
				</div>
			</form>
			<hr>
			<?php endif;?>

			<!-- Heading -->
			<h1 class="text-center title-color mt-5 mb-5">Announcements</h1>

			<!-- Announcements table -->
			<div class="container" id="main">
			<?php while($row = $results->fetch_assoc()):?>
				<div class="row">
					<div class="col-12">
						<div class="announcement">
							<h3 class="title-color"><?php echo $row['title'];?></h3>
							<p><?php echo $row['text'];?></p>
							<hr>
						</div>
					</div>
				</div>
			<?php endwhile;?>
			</div>

			<!-- Pagination Bar -->
			<div class="container">
				<div class="row">
					<div class="col-12 mb-3">
						<ul class="pagination justify-content-center">
							<li class="page-item">
								<a class="bg-dark text-light page-link" href="announcements.php">First</a>
							</li>
							<li class="page-item">
								<a class="bg-dark text-light page-link" href="announcements.php?page=<?php echo $previous_page;?>" aria-label="Previous">
									<span aria-hidden="true">&laquo;</span>
									<span class="sr-only">Previous</span>
								</a>
							</li>
							<li class="page-item">
								<a class="bg-light text-dark page-link"><?php echo $current_page;?></a>
							</li>
							<a class="bg-dark text-light page-link" href="announcements.php?page=<?php echo $next_page;?>" aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
								<span class="sr-only">Next</span>
							</a>
							<li class="page-item">
								<a class="bg-dark text-light page-link" href="announcements.php?page=<?php echo $last_page;?>">Last</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Footer -->
		<div class="text-light bg-dark text-center" id="footer">
			© 2020 Dentō Dojo
		</div>
	</div>

	<?php 
		if(isset($_SESSION['update_message']) && !empty($_SESSION['update_message'])){
			$msg = $_SESSION['update_message'];
			unset($_SESSION['update_message']);
			echo "<script type='text/javascript'>alert('$msg');</script>";
		}
	?>
	<?php if(isset($_SESSION['user']) && $_SESSION['user'] == "Sensei"):?>
	<!-- Validation -->
	<script src="../javascript/announ_validation.js"></script>
	<!-- Other scripts -->
	<?php endif;?>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>