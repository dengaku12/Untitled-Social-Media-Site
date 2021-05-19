<?php 
    include_once 'dbconnect.inc.php';

    function validateStr($input){
		$input = trim($input);
		$input = stripcslashes($input);
		$input = htmlspecialchars($input);
		return $input;
	}

    session_start();
    if(!isset($_SESSION["username"])){
        echo "You are not logged in <br>";
        echo "<a href='login.php'>Login</a>";
        exit;
    }

    if(isset($_POST["submit"])){
        $title = validateStr($_POST["title"]);
        $description = validateStr($_POST["description"]);
        date_default_timezone_set('America/New_York');
        $post_date = date('Y-m-d');

        if(empty($_POST["title"])){
            $errors["title"] = "The post needs a title";
        }

        if(empty($_POST["description"])){
            $errors["description"] = "You need words in your post";
        }
        
        if(isset( $_FILES["photo"]["type"]) && $_FILES["photo"]["error"] == 0 && !empty($_POST["title"]) && !empty($_POST["description"])){
            $target_dir = "photos/";
            $target_file = $target_dir.basename($_FILES["photo"]["name"]);

            $file_type = pathinfo($target_file,PATHINFO_EXTENSION);
            $accepted = array("jpg", "JPG", "jpeg", "JPEG", "png", "PNG", "WEBP", "gif");

            if(!in_array($file_type, $accepted)){
				echo "Only images can be uploaded";
			}
            else if(!move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file))
			{
				echo "There was a problem uploading that photo".$_FILES["photo"]["error"];
			} else{
                $query = "INSERT INTO posts (title, description, user_id_fk, post_date, image)";
                $query .= "VALUES (?, ?, ?, ?, ?)";
                
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ssiss", $title, $description, $_SESSION["user_id"], $post_date, $target_file);
                if($stmt->execute()){
                    echo "Your new post has been created<br>";
                }

            }
        }
        else if($_FILES["photo"]["error"] === 4 && !empty($_POST["title"]) && !empty($_POST["description"])){
            $query = "INSERT INTO posts (title, description, user_id_fk, post_date)";
            $query .= "VALUES (?, ?, ?, ?)";
            echo empty($_POST["title"]);
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssis", $title, $description, $_SESSION["user_id"], $post_date);
            $stmt->execute();
            echo "Your new post has been created<br>";
        }
        else{
            switch( $_FILES["photo"]["error"] ) {
                case 1: //max size set up in php.ini
                   $message = "The image size is larger than the server allows.";
                    break;
                case 2: //max size set up in html form
                    $message = "The image size is larger than the script allows.";
                    break;
                default:
                    $message = "Make sure your post has a title and description. Your image also might not be valid";
           } echo "Sorry, there was a problem creating the post: ".$message;
        }
        
    }

?>