<?php
	require 'config/config.php';

	//first check that it is a sensei user
	if($_SESSION['user'] == "Sensei"){
		$message = "";
		// Check if any req fields are missing or empty
		if(!isset($_GET['class-id']) || empty($_GET['class-id'])){
			$message = "Unable to delete class: id not specificed.";
		} else {
			// Establish connection
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if ( $mysqli->errno ) {
				echo $mysqli->error;
				exit();
			}
			// Prepared statement - delete roster entries with matching class_ids
			$statement = $mysqli->prepare("DELETE from roster WHERE class_id=?");
			$statement->bind_param("i", $_GET['class-id']);
			$executed = $statement->execute();
			// DB error checking
			if(!$executed){
				echo $mysqli->error;
				exit();
			}
			// Check that roster entries were deleted
			if($mysqli->affected_rows > 1) {
				$message .= 'Removed class from roster! ';
			}

			// Prepared statement - delete class with matching class_ids
			$statement->close();
			$statement = $mysqli->prepare("DELETE from classes WHERE id=?");
			$statement->bind_param("i", $_GET['class-id']);
			$executed = $statement->execute();
			// DB error checking
			if(!$executed){
				echo $mysqli->error;
				exit();
			}
			// Check that class was deleted
			if($mysqli->affected_rows == 1) {
				$message .= 'Deleted class from classes!';
			}

			// Close connection
			$statement->close();
			$mysqli->close();
		}
		$_SESSION['update_message'] = $message;
		header("Location: pages/schedule.php");
	}
	else {
		header("Location: pages/schedule.php");
	}
?>