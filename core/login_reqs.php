<?php
include '../admin/vars.php';

$paradox_mysql_link = new mysqli($paradox_mysql_server, $paradox_mysql_user, $paradox_mysql_password, $paradox_db);

	if((isset($_POST["login_process"])) || !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		$process = $_POST["login_process"];
		$username = $_POST["username"];
		$clientpassword = $_POST["password"];
		$response = "";

		if (isset($_SESSION['login_tries'])) {
			$_SESSION['login_tries'] = $_SESSION['login_tries'] + 1;
		}

		$uSQL="SELECT * FROM user where username like '" . $username . "';";

		$rsUser = $paradox_mysql_link->query($uSQL) or die('Error querying database');

		$num_rows = mysqli_num_rows($rsUser);

		if($num_rows >0) {
			while($UserLine = mysqli_fetch_array($rsUser)) {
				if(md5($clientpassword)==$UserLine["userpassword"]) {

					$_SESSION['siteuser']=$UserLine["userid"];
					$_SESSION['username']=$UserLine["username"];
					$_SESSION['admin']=$UserLine["isadmin"];
					$_SESSION['dev']=$UserLine["isdev"];
					$_SESSION['salesadmin']=$UserLine["issalesadmin"];
					$_SESSION['user_full_name']=$UserLine["userrealname"];

					$response = "true";
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

		header("Location: ../index.php");

		echo "true";
	} else {
		echo "false";
	}

	if(isset($_POST["log_out"])) {
			session_start();
			session_destroy();
			header("Location: ../login.php");
	} else {
		$logout="false";
	}
$paradox_mysql_link->close();
?>
