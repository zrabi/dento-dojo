<?php
	require 'config/config.php';

	//first check that it is a sensei user
	if($_SESSION['user'] == "Sensei"){
		// Check if any req fields are missing or empty
		if(!isset($_POST['class-name']) || empty($_POST['class-name']) 
			|| !isset($_POST['class-time']) || empty($_POST['class-time'])
			|| !isset($_POST['class-id']) || empty($_POST['class-id'])
			|| !isset($_POST['class-day']) || empty($_POST['class-day'])){
			$message = "Please fill out all required fields";
		} else{
			// Establish connection
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if ( $mysqli->errno ) {
				echo $mysqli->error;
				exit();
			}
			// Do some time string manipulation
			$timeArray = explode(":",$_POST['class-time']);
			$timeHours = (int)$timeArray[0];
			$timeMins = $timeArray[1];
			if($timeHours > 12){
				$timeHours = $timeHours -12;
				$ampm = "PM";
			} else if($timeHours < 12){
				$ampm = "AM";
				if($timeHours == 0){
					$timeHours = 12;
				}
			} else {
				$ampm = "PM";
			}
			$actualTime = strval($timeHours).":".$timeMins." ".$ampm;
			// Prepared statement
			$statement = $mysqli->prepare("UPDATE classes SET class=?, time=?, day=? WHERE id=?");
			$statement->bind_param("sssi", $_POST['class-name'], $actualTime, $_POST['class-day'], $_POST['class-id']);
			$executed = $statement->execute();
			// DB error checking
			if(!$executed){
				echo $mysqli->error;
				exit();
			}
			// Check that it was inserted
			if($mysqli->affected_rows == 1) {
				$message = 'All changes to class "'. $_POST['class-name'] .'" were saved!';
			}

			// Close connection
			$statement->close();
			$mysqli->close();
		}
		$_SESSION['update_message'] = $message;
		header("Location: pages/schedule.php");
	}
	else{
		header("Location: pages/schedule.php");
	}
?>