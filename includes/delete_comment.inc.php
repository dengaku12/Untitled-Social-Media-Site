<?php 
    include_once 'dbconnect.inc.php';

    if(isset($_POST["submit"])){
        $query = "DELETE FROM comments WHERE comment_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $_POST["comment_id"]);
        $stmt->execute();
        echo "Your comment has been deleted<br>";
    }
    $post_id = $_POST["post_id"];
    echo "<a href='../comments.php?post_id=$post_id'>Back to Comments</a>";

?>
