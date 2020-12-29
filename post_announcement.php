<?php
	require 'config/config.php';
	//first check that it is a sensei user
	if($_SESSION['user'] == "Sensei"){
		// Check if any req fields are missing or empty
		if(!isset($_POST['title']) || empty($_POST['title']) || !isset($_POST['text']) || empty($_POST['text'])){
			$message = "Please fill out all required fields";
		}
		else{
			// Establish connection
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if ( $mysqli->errno ) {
				echo $mysqli->error;
				exit();
			}

			// Prepared statement
			$statement = $mysqli->prepare("INSERT INTO announcements (title,text) VALUES(?,?)");
			$statement->bind_param("ss", $_POST['title'], $_POST['text']);
			$executed = $statement->execute();
			// DB error checking
			if(!$executed){
				echo $mysqli->error;
				exit();
			}
			// Check that it was inserted
			if($mysqli->affected_rows == 1) {
				$message = 'The announcement titled "'. $_POST['title'] .'" was posted!';
			}

			// Close connection
			$mysqli->close();
		}
		$_SESSION['update_message'] = $message;
		header("Location: pages/announcements.php");
	} else{
		header("Location: pages/announcements.php");
	}
?>