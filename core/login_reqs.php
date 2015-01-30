<?php
include '../admin/config.php';

$paradox_mysql_link = new mysqli($paradox_mysql_server, $paradox_mysql_user, $paradox_mysql_password, $paradox_db);
	if((isset($_POST["login_process"])) || !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		$process = $_POST["login_process"];
		$clientname = $_POST["username"];
		$clientpassword = $_POST["password"];
		$response = "";

		$uSQL="SELECT * FROM user where username like '".$clientname."';";

		$rsUser = $paradox_mysql_link->query($uSQL) or die('Error querying database');

		$num_rows = mysqli_num_rows($rsUser);

		if($num_rows >0) {
			while($UserLine = mysqli_fetch_array($rsUser)) {
				if(md5($clientpassword)==$UserLine["userpassword"]) {
					session_start();

					$_SESSION['siteuser']=$UserLine["userid"];
					$_SESSION['admin']=$UserLine["isadmin"];
					$_SESSION['dev']=$UserLine["isdev"];
					$_SESSION['salesadmin']=$UserLine["issalesadmin"];
					$response = "true";
					header("Location: ../index.php");
					echo $response;
				} else {
					$response = "error";
					return $response;
					echo $response;
				}
			}
		} else {
			$response = "false";
			return $response;
			echo $response;
		}
	} else {
		echo "false";
	}

	if(isset($_POST["logout"])) {
		$logout = $_GET["logout"];

		if($logout=="true") {
			session_start();
			session_destroy();
			header("Location: ../login.php");
		}
	} else {
		$logout="false";
	}
$paradox_mysql_link->close();
?>