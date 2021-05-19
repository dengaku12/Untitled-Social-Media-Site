<?php
	include_once "dbconnect.inc.php";

	function validateStr($input){
		$input = trim($input);
		$input = stripcslashes($input);
		$input = htmlspecialchars($input);
		return $input;
	}

	if(isset($_POST["submit"])){
		$username = validateStr($_POST["username"]);
        $password = validateStr($_POST["password"]);
        $found = false;

		if(empty($_POST["username"])){
			$errors["username"] = "you need a username";
		}

		if(empty($_POST["password"])){
			$errors["password"] = "you need a password";
		}

		$query = "SELECT user_id, username, password FROM users WHERE username = ? LIMIT 1";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$result = $stmt->get_result();
		$user = $result->fetch_assoc();

		if($result->num_rows > 0 && password_verify($password, $user["password"])){
			$found = true;
			session_start();
			$_SESSION["user_id"] = $user["user_id"];
			$_SESSION["username"] = $username;
		}

		if($found){
			header("Location: home.php");
		}
	}

?>