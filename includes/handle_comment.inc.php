<?php 
    include_once 'dbconnect.inc.php';

    function validateStr($input){
		$input = trim($input);
		$input = stripcslashes($input);
		$input = htmlspecialchars($input);
		return $input;
	}

    if(isset($_POST["submit"])){
        session_start();
        $comment = validateStr($_POST["comment"]);
        date_default_timezone_set('America/New_York');
        $comment_date = date('Y-m-d');

        $query = "INSERT INTO comments (comment, user_id_fk, post_id_fk, comment_date) VALUES (?,?,?,?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("siis", $comment, $_SESSION["user_id"], $_POST["post_id"], $comment_date);
        $stmt->execute();
        header("Location: ../comments.php?post_id=".$_POST["post_id"]);
    }
?>