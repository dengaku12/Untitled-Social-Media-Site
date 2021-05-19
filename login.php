<?php
	//functions include and require to import html/php files into a php file.
	require 'includes/handle_login.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<link rel="stylesheet" href="style/mystyle.css">
	<title>Login</title>
</head>
<body>
	<h2 class="line">Untitled Social Media Site</h2>
	<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="form">
		<?php 
			if(isset($_POST["submit"]) && !$found)
			{
				echo "That username and password combination does not match our records. 
				Please try again";
			}
			else{
				echo "";
			}
		?>
		
		<div class="container">
			<label for="username"><b>Username</b></label>
			<input type="text" placeholder="Enter Username" name="username" id="username">
			<small>
                <?php echo (isset($errors["username"])) ? $errors["username"] : ""; ?>
            </small>
			<br><br>
		
			<label for="password"><b>Password</b></label>
			<input type="password" placeholder="Enter Password" name="password" id="password">
			<small>
                <?php echo (isset($errors["password"])) ? $errors["password"] : ""; ?>
            </small>
			<br><br>
		</div>

		</div>
			<input type="submit" name="submit" value="Login">
		</div>
	</form>

	<div class="center">
	<h5>If you don't have an account click the Signup button below.</h5>
		<a href="signup.php">
			<button>Signup</button>
		</a>
	</div>
	
</body>
</html>