<?php 
    include_once 'dbconnect.inc.php';

    if(isset($_POST["submit"])){
        $query = "DELETE FROM comments WHERE post_id_fk = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $_POST["post_id"]);
        $stmt->execute();
        $query = "DELETE FROM posts WHERE post_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $_POST["post_id"]);
        $stmt->execute();
        echo "Your post has been deleted<br>";
    }

?>
<a href="../home.php">Back to Posts</a>