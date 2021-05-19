<?php
	//functions include and require to import html/php files into a php file.
	require 'includes/handle_signup.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<link rel="stylesheet" href="style/mystyle.css">
	<title>Signup</title>
</head>
<body>
	<h2 class="line">Create Your Account Here!</h2>
	<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="form">
		<?php 
			if(isset($_POST["submit"]) && $found)
			{
				echo "That username has already been taken. Please try again";
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

			<label for="email"><b>Email</b></label>
      		<input type="email" placeholder="Enter Email" name="email" id="email">
			<small>
                <?php echo (isset($errors["email"])) ? $errors["email"] : ""; ?>
            </small>  
			<br><br>

		</div>

		</div>
			<input type="submit" name="submit" value="Signup">
		</div>
	</form>
	<div class="center">
		<h5>Already have an account? Login below</h5>
		<a href="login.php">
			<button>Login</button>
		</a>
	</div>
</body>
</html>