<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']):?>
<!-- Logged-in Banner -->
	<div id="logged-in">
		Logged in as <?php echo $_SESSION['user'] . " " . $_SESSION['name'];?>
	</div>
<?php endif;?>