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
		$email = validateStr($_POST["email"]);
		$found = false;
		$valid = false;

		if(empty($_POST["username"])){
			$errors["username"] = "you need a username";
		}

		if(empty($_POST["password"])){
			$errors["password"] = "you need a password";
		}

		if(empty($_POST["email"])){
			$errors["email"] = "you need an email";		
		}

		$query = "SELECT username FROM users WHERE username = ? LIMIT 1";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$stmt->store_result();

		if($stmt->num_rows > 0){
			$found = true;
		}

		$pattern = "/[a-zA-Z]+[0-9]+/";

        if(preg_match($pattern, $password)){
            $valid = true;
        }

		if(!$found && !empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["email"]) && $valid){
			$hashpass = password_hash($password, PASSWORD_DEFAULT);
			$query = "INSERT INTO users (username, password, email) VALUES (?,?,?)";
			$stmt = $conn->prepare($query);
			$stmt->bind_param("sss", $username, $hashpass, $email);
			$stmt->execute();
			echo "$username has successfully signed up!";
		}
		elseif(!$found && !empty($_POST["username"]) && !empty($_POST["password"]) && !$valid){
            echo "Password must start with a letter and must include a number";
        }
        else{
            echo "";
        }
	}

?>