<?php
	require '../config/config.php';
	$_SESSION['page'] = "Schedule";

	// Establish connection to DB
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if($mysqli->connect_errno){
		echo $mysqli->connect_error;
		exit();
	}
	$mysqli->set_charset('utf8');

	
	// Display results on the Website - done below
	$week_schedule = array("","","","","","","");

	// If student user is logged in, need to get roster
	if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $_SESSION['user'] == "Student"){
		// SQL Query - No need to prepare here
		$sql = "SELECT classes.id, classes.class, classes.sensei_id, roster.student_id, classes.time, classes.day, senseis.name 
				FROM classes 
				LEFT JOIN senseis 
					ON senseis.id = classes.sensei_id 
				LEFT JOIN roster 
					ON roster.class_id = classes.id 
				WHERE student_id = ".$_SESSION['user_id']."
				UNION
				SELECT * FROM 
					(SELECT classes.id, classes.class, classes.sensei_id, NULL as student_id, classes.time, classes.day, senseis.name 
					FROM classes 
					LEFT JOIN senseis 
						ON senseis.id = classes.sensei_id) AS T1
				WHERE id NOT IN 
					(SELECT classes.id 
					FROM classes 
					LEFT JOIN senseis 
						ON senseis.id = classes.sensei_id 
					LEFT JOIN roster 
						ON roster.class_id = classes.id 
					WHERE student_id = ".$_SESSION['user_id'].")
				ORDER BY STR_TO_DATE(time,'%l:%i %p'), sensei_id ASC;";
		$results = $mysqli->query($sql);
		if(!$results){
			echo $mysqli->error;
			exit();
		}
	} else{
		// SQL Query - No need to prepare here
		$sql = "SELECT classes.id, classes.class, classes.sensei_id, classes.time, classes.day, senseis.name FROM classes
				LEFT JOIN senseis ON senseis.id = classes.sensei_id ORDER BY STR_TO_DATE(time,'%l:%i %p'), classes.sensei_id ASC;";
		$results = $mysqli->query($sql);
		if(!$results){
			echo $mysqli->error;
			exit();
		}
	}

	while($row = $results->fetch_assoc()){
		$index = 0;
		$week_days = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
		if($row['day'] == "Sunday"){
			$index = 0;
		} else if($row['day'] == "Monday"){
			$index = 1;
		} else if($row['day'] == "Tuesday"){
			$index = 2;
		} else if($row['day'] == "Wednesday"){
			$index = 3;
		} else if($row['day'] == "Thursday"){
			$index = 4;
		} else if($row['day'] == "Friday"){
			$index = 5;
		} else if($row['day'] == "Saturday"){
			$index = 6;
		}
		if((isset($_SESSION['user']) && $_SESSION['user'] == "Sensei" && $row['sensei_id'] == $_SESSION['user_id'])
			|| (isset($_SESSION['user']) && $_SESSION['user'] == "Student" && $row['student_id'] == $_SESSION['user_id'])){
			$colorClass = "btn-primary";
		} else{
			$colorClass = "btn-secondary";
		}
		// When Sensei logged in
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $_SESSION['user'] == "Sensei"){
			$timeArray = explode(" ",$row['time']);
			$ampm = $timeArray[1];
			$timeArray = explode(":",$timeArray[0]);
			$timeHrs = (int)$timeArray[0];
			$timeMins = (int)$timeArray[1];
			if($ampm == "PM"){
				if($timeHrs != 12){
					$timeHrs = $timeHrs + 12;
				}
			} else if ($ampm == "AM"){
				if($timeHrs == 12){
					$timeHrs = $timeHrs - 12;
				}
			}
			$calcTime = sprintf("%02d", strval($timeHrs)).":".sprintf("%02d", strval($timeMins));
			// Button
			$week_schedule[$index] .= '<button data-target="#ModalCenterClass'.$row['id'].'" data-toggle="modal" class="btn '.$colorClass.' class"><input type="hidden" name="class-id" value="'.$row['id'].'">Sensei '.$row['name'].'<br/>'.$row['class'].'<br/>'.$row['time'].'</button>';
			// Modal
			$week_schedule[$index] .=
			'<div class="modal fade" id="ModalCenterClass'.$row['id'].'" tabindex="-1" role="dialog" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title">Edit Class '.$row['class'].'</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			    <form action="../edit_class.php" method="POST" onsubmit="return confirm(\'Are you sure you want to save these edits?\')">
			      <div class="modal-body">
			        Sensei '.$row['name'].'</br>'.$row['time'].'</br>'.$week_days[$index].'
			        <div class="form-group text-left">
						<label for="edit-class-name'.$row['id'].'"><span class="text-danger">*</span>Class Name:</label>
						<input id="class-edit-name'.$row['id'].'" type="text" name="class-name" aria-describedby="class-edit'.$row['id'].'" class="form-control" value="'.$row['class'].'">
						<small id="class-edit'.$row['id'].'" class="namesSmall form-text text-muted">*required field, max 50 characters</small>
					</div>
					<div class="form-group text-left">
						<label for="edit-class-time'.$row['id'].'"><span class="text-danger">*</span>Class Time:</label>
						<input value ="'.$calcTime.'" name="class-time" aria-describedby="time-edit'.$row['id'].'" type="time" id="edit-class-time'.$row['id'].'" class="form-control">
						<small id="time-edit'.$row['id'].'" class="timesSmall form-text text-muted">*required field, specify time (AM/PM)</small>
					</div>
					<div class="form-group text-left">
						<label for="edit-class-day'.$row['id'].'"><span class="text-danger">*</span>Class Day:</label>
						<select name="class-day" aria-describedby="day-edit'.$row['id'].'" id="edit-class-day'.$row['id'].'" class="form-control">
							<option value="0" disabled>Select Day</option>';
						for($i = 0; $i < 7; $i++){
							if($row['day'] == $week_days[$i]){
								$week_schedule[$index] .= '<option selected value="'.$row['day'].'">'.$row['day'].'</option>';
							} else{
								$week_schedule[$index] .= '<option value="'.$week_days[$i].'">'.$week_days[$i].'</option>';
							}
						}
						$week_schedule[$index] .=
						'</select>
						<small id="day-edit'.$row['id'].'" class="daysSmall form-text text-muted">*required field, specify day</small>
					</div>
			      </div>
			      <div class="modal-footer">
			      	<input type="hidden" name="class-id" value="'.$row['id'].'">
			        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
			        <button type="submit" class="btn btn-outline-primary">
						Save Edits
					</button>'.
					'<a onclick="return confirm(\'Are you sure you want to delete this class?\')" href="../delete_class.php?class-id='.$row['id'].'" class="btn btn-outline-danger">
						Delete Class
					</a>
			      </div>
			    </form>
			    </div>
			  </div>
			</div>';
		}
		// When Student is logged in
		else if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $_SESSION['user'] == "Student"){
			// Button
			$week_schedule[$index] .= '<button data-target="#ModalCenterClass'.$row['id'].'" data-toggle="modal" class="btn '.$colorClass.' class"><input type="hidden" name="class-id" value="'.$row['id'].'"><input type="hidden" name="student-id" value="'.$row['student_id'].'">Sensei '.$row['name'].'<br/>'.$row['class'].'<br/>'.$row['time'].'</button>';
			// Modal
			$week_schedule[$index] .=
			'<div class="modal fade" id="ModalCenterClass'.$row['id'].'" tabindex="-1" role="dialog" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title">'.$row['class'].'</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        Sensei '.$row['name'].'</br>'.$row['time'].'
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
			        ';
			if($colorClass == "btn-secondary"){
				$week_schedule[$index] .= '<a onclick="return confirm(\'Are you sure you want to enroll in this class?\')" href="../enroll_class.php?student_id='.$_SESSION['user_id'].'&class_id='.$row['id'].'" class="btn btn-outline-success">
				Enroll
				</a>';
			} else{
			    $week_schedule[$index] .=
			    '<a onclick="return confirm(\'Are you sure you want to drop this class?\')" href="../drop_class.php?student_id='.$_SESSION['user_id'].'&class_id='.$row['id'].'" class="btn btn-outline-danger">
				Drop Class
				</a>';
			}	
			$week_schedule[$index] .='</div>
			    </div>
			  </div>
			</div>';
		}
		// Guest user
		else{
			$week_schedule[$index] .= '<button class="btn btn-secondary class">Sensei '.$row['name'].'<br/>'.$row['class'].'<br/>'.$row['time'].'</button>';
		}
	}

	// Close connection
	$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Schedule | Dentō Dojo</title>
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
			<!-- New Class Form-->
			<form id="class-form" class="mb-5" method="POST" action="../add_class.php">
				<h1 class="text-center title-color mt-5 mb-5">Add a New Class</h1>
				<div class="container">
					<div class="row">
						<div class="col-md-4 col-12">
							<div class="form-group">
								<label for="new-class-name"><span class="text-danger">*</span>Class Name:</label>
								<input id="class-form-name" type="text" name="class-name" aria-describedby="class-help" class="form-control" placeholder="Enter Class Name">
								<small id="class-help" class="form-text text-muted">*required field, max 50 characters</small>
							</div>
						</div>
						<div class="col-md-4 col-12">
							<div class="form-group">
								<label for="new-class-time"><span class="text-danger">*</span>Class Time:</label>
								<input name="class-time" aria-describedby="time-help" type="time" id="new-class-time" class="form-control">
								<small id="time-help" class="form-text text-muted">*required field, specify time (AM/PM)</small>
							</div>
						</div>
						<div class="col-md-4 col-12">
							<div class="form-group">
								<label for="new-class-day"><span class="text-danger">*</span>Class Day:</label>
								<select name="class-day" aria-describedby="day-help" id="new-class-day" class="form-control">
									<option value="0" selected disabled>Select Day</option>
									<option value="Sunday">Sunday</option>
									<option value="Monday">Monday</option>
									<option value="Tuesday">Tuesday</option>
									<option value="Wednesday">Wednesday</option>
									<option value="Thursday">Thursday</option>
									<option value="Friday">Friday</option>
									<option value="Saturday">Saturday</option>
								</select>
								<small id="day-help" class="form-text text-muted">*required field, specify day</small>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<button type="submit" class="btn btn-primary">Create</button>
							<input class="btn btn-secondary" type="reset" value="Reset">
						</div>
					</div>
				</div>
			</form>
			<hr>
			<?php endif;?>

			<!-- Heading -->
			<h1 class="text-center title-color mt-5 mb-5">Schedule</h1>

			<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']):?>
				<?php if(isset($_SESSION['user']) && $_SESSION['user'] == "Sensei"):?>
				<div class="container text-center mb-3">
					Click on a Class to Edit or Delete it
					<br/>
					Legend:
					<button class="btn btn-primary"></button> - Your Classes
					<span class="ml-2 mr-2"></span>
					<button class="btn btn-secondary"></button> - Other Classes
				</div>
				<?php else:?>
				<div class="container text-center mb-3">
					Click on a Class to Enroll or Drop it
					<br/>
					Legend:
					<button class="btn btn-primary"></button> - Your Enrolled Classes
					<span class="ml-2 mr-2"></span>
					<button class="btn btn-secondary"></button> - Other Classes
				</div>
				<?php endif;?>
			<?php endif;?>

			<!-- Schedule table -->
			<div class="schedule-container mb-5">
				<div class="schedule-col">
					<h4>Sunday</h4>
					<?php 
						if($week_schedule[0] ==""){
							echo "No classes";
						} else{
							echo $week_schedule[0];
						}
					?>
				</div>
				<div class="schedule-col">
					<h4>Monday</h4>
					<?php 
						if($week_schedule[1] ==""){
							echo "No classes";
						} else{
							echo $week_schedule[1];
						}
					?>
				</div>
				<div class="schedule-col">
					<h4>Tuesday</h4>
					<?php 
						if($week_schedule[2] ==""){
							echo "No classes";
						} else{
							echo $week_schedule[2];
						}
					?>
				</div>
				<div class="schedule-col">
					<h4>Wednesday</h4>
					<?php 
						if($week_schedule[3] ==""){
							echo "No classes";
						} else{
							echo $week_schedule[3];
						}
					?>
				</div>
				<div class="schedule-col">
					<h4>Thursday</h4>
					<?php 
						if($week_schedule[4] ==""){
							echo "No classes";
						} else{
							echo $week_schedule[4];
						}
					?>
				</div>
				<div class="schedule-col">
					<h4>Friday</h4>
					<?php 
						if($week_schedule[5] ==""){
							echo "No classes";
						} else{
							echo $week_schedule[5];
						}
					?>
				</div>
				<div class="schedule-col">
					<h4>Saturday</h4>
					<?php 
						if($week_schedule[6] ==""){
							echo "No classes";
						} else{
							echo $week_schedule[6];
						}
					?>
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
		if(isset($_SESSION['drop_message']) && !empty($_SESSION['drop_message'])){
			$msg = $_SESSION['drop_message'];
			unset($_SESSION['drop_message']);
			echo "<script type='text/javascript'>alert('$msg');</script>";
		}
		if(isset($_SESSION['enroll_message']) && !empty($_SESSION['enroll_message'])){
			$msg = $_SESSION['enroll_message'];
			unset($_SESSION['enroll_message']);
			echo "<script type='text/javascript'>alert('$msg');</script>";
		}
	?>
	<?php if(isset($_SESSION['user']) && $_SESSION['user'] == "Sensei"):?>
	<!-- Validation -->
	<script src="../javascript/class_validation.js"></script>
	<script src="../javascript/edit_validation.js"></script>
	<!-- Other scripts -->
	<?php endif;?>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>