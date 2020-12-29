<?php
	require 'config/config.php';

	// Check that someone is logged in, is the actual student, and all req fields are given
	if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $_SESSION['user'] == "Student" && isset($_GET['student_id']) && !empty($_GET['student_id']) && $_SESSION['user_id'] == $_GET['student_id'] &&  isset($_GET['class_id']) && !empty($_GET['class_id'])){
		// Establish connection
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ( $mysqli->errno ) {
			echo $mysqli->error;
			exit();
		}
		// Prepared statement
		$statement = $mysqli->prepare("DELETE FROM roster WHERE student_id=? AND class_id=?");
		$statement->bind_param("ii", $_GET['student_id'], $_GET['class_id']);
		$executed = $statement->execute();
		// DB error checking
		if(!$executed){
			echo $mysqli->error;
			exit();
		}
		if($statement->affected_rows == 1){
			$message = "Class dropped successfully!";
		}
		$statement->close();
		$mysqli->close();
	}
	// otherwise, just redirect back to schedule
	else{
		$message = "Unable to drop class!";
	}
	$_SESSION['drop_message'] = $message;
	header("Location: pages/schedule.php");
?>