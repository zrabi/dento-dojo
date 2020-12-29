<?php
	// need to start session to destroy it
	session_start();
	// removes all stored session variables
	session_destroy();
	header("Location: ../pages/index.php");
?>