<?php

	include('../php-utils/user_variables.php');

	if($_SESSION['type'] == "admin") {
		
		$id = mysqli_real_escape_string($mysqli, $_SESSION["id"]);
		$query = "INSERT INTO `hod`(`username`, `email`, `password`, `admin_id`) VALUES (`$username`,`$email`,`$password`,`$id`)";

		$run = mysqli_query($mysqli, $query);
	}
	else
		echo "Not an admin! Can't add HOD!";

?>