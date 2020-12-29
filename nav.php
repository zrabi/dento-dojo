<nav class="navbar navbar-dark bg-dark navbar-expand-md">
	<!-- Navbar brand -->
	<a class="navbar-brand" href="index.php"><i class="fas fa-torii-gate"></i> Dentō Dojo</a>
	<!-- Navbar hamburger button -->
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span>
	</button>
	<!-- Content -->
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<!-- List -->
		<ul class="navbar-nav navbar-center text-center">
			<!-- Home -->
			<?php if($_SESSION['page'] == "Home"):?>
			<li class="nav-item active">
				<a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
			</li>
			<?php else:?>
			<li class="nav-item">
				<a class="nav-link" href="index.php">Home</a>
			</li>
			<?php endif;?>

			<!-- Schedule -->
			<?php if($_SESSION['page'] == "Schedule"):?>
			<li class="nav-item active">
				<a class="nav-link" href="schedule.php">Schedule<span class="sr-only">(current)</span></a>
			</li>
			<?php else:?>
			<li class="nav-item">
				<a class="nav-link" href="schedule.php">Schedule</a>
			</li>
			<?php endif;?>

			<!-- Announcements -->
			<?php if($_SESSION['page'] == "Announcements"):?>
			<li class="nav-item active">
				<a class="nav-link" href="announcements.php">Announcements<span class="sr-only">(current)</span></a>
			</li>
			<?php else:?>
			<li class="nav-item">
				<a class="nav-link" href="announcements.php">Announcements</a>
			</li>
			<?php endif;?>

			<!-- Senseis -->
			<?php if($_SESSION['page'] == "Senseis"):?>
			<li class="nav-item active">
				<a class="nav-link" href="senseis.php">Senseis<span class="sr-only">(current)</span></a>
			</li>
			<?php else:?>
			<li class="nav-item">
				<a class="nav-link" href="senseis.php">Senseis</a>
			</li>
			<?php endif;?>

			<!-- Register/Log out -->
			<?php if(!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']):?>
				<?php if($_SESSION['page'] == "Register"):?>
				<li class="nav-item active">
					<a class="nav-link" href="register.php">Register<span class="sr-only">(current)</span></a>
				</li>
				<?php else:?>
				<li class="nav-item">
					<a class="nav-link" href="register.php">Register</a>
				</li>
				<?php endif;?>
			<?php else:?>
				<?php if($_SESSION['page'] == "Register"):?>
				<li class="nav-item active">
					<a class="nav-link" href="../login/logout.php">Log Out<span class="sr-only">(current)</span></a>
				</li>
				<?php else:?>
				<li class="nav-item">
					<a class="nav-link" href="../login/logout.php">Log Out</a>
				</li>
				<?php endif;?>
			<?php endif;?>
		</ul>
	</div>
</nav>