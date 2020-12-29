<?php
	require '../config/config.php';
	// Check Session - if not logged in, run it
	if(!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']){
		// Check if username and password exist in POST
		if(isset($_POST['email']) && isset($_POST['password'])){
			// Check that they aren't empty
			if(empty($_POST['email']) || empty($_POST['password'])){
				$error = "Please enter an email and a password.";
			}
			// Check that they are correct
			else{
				$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
				if($mysqli->connect_errno) {
					echo $mysqli->connect_error;
					exit();
				}
				// Hashed user input for password
				$passwordInput = hash("sha256", $_POST['password']);
				
				// First check senseis table
				$statement = $mysqli->prepare("SELECT * FROM senseis WHERE email = ? AND password = ?");
				$statement->bind_param("ss", $_POST['email'], $passwordInput);
				$executed = $statement->execute();
				// DB error checking
				if(!$executed){
					echo $mysqli->error;
					exit();
				}
				// Match checking
				$results = $statement->get_result();
				if($results->num_rows == 1){
					$row = $results->fetch_assoc();
					$_SESSION['name'] = $row['name'];
					$_SESSION['logged_in'] = true;
					$_SESSION['user'] = "Sensei";
					$_SESSION['user_id'] = $row['id'];
					$statement->close();
					// Redirect the logged in user to the home page
					header("Location: ../pages/index.php");
					exit();
				}

				// No match yet, check students
				$statement->close();
				$statement = $mysqli->prepare("SELECT * FROM students WHERE email = ? AND password = ?");
				$statement->bind_param("ss", $_POST['email'], $passwordInput);
				$executed = $statement->execute();
				// DB error checking
				if(!$executed){
					echo $mysqli->error;
					exit();
				}
				$results = $statement->get_result();
				if($results->num_rows == 1){
					$row = $results->fetch_assoc();
					$_SESSION['name'] = $row['name'];
					$_SESSION['logged_in'] = true;
					$_SESSION['user'] = "Student";
					$_SESSION['user_id'] = $row['id'];
					$statement->close();
					// Redirect the logged in user to the home page
					header("Location: ../pages/index.php");
					exit();
				}
				else {
					$error = "Invalid username or password.";
				}
				$statement->close();
				$mysqli->close();
			}
			if(isset($error) && !empty($error)){
				$_SESSION['login_error'] = $error;
				header("Location: ../pages/index.php");
			}
		}
	}
	// Otherwise, redirect to home page
	header("Location: ../pages/index.php");
?>