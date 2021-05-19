<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/mystyle.css">
    <title>Comments</title>
</head>
<body>
    <?php 
        include_once "includes/dbconnect.inc.php";
        session_start();
        if(!isset($_SESSION["username"])){
            echo "You are not logged in <br>";
            echo "<a href='login.php'>Login</a>";
            exit;
        }
    ?>
    <a href="home.php">
        <button>
            Posts
        </button>
    </a>
    <br><br>
    <?php 
        if(isset($_GET["post_id"])){
            $post_id = $_GET["post_id"];

            $query = "SELECT description, image, post_date, username FROM posts, users ";
            $query .= "WHERE user_id_fk = user_id AND post_id = ? LIMIT 1";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $post_id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($desc, $image, $post_date, $user);
            $stmt->fetch();
            echo "@$user   $post_date<br>";
            echo "<p>$desc</p>";
            if(!!$image){
                echo "<img src='$image' width='400'><br>";
            }
            echo "<br><hr><hr>";
            echo "<h4>Comments</h4>";

            $query = "SELECT comment_id, comment, comment_date, username FROM comments, users ";
            $query .= "WHERE user_id_fk = user_id AND post_id_fk = ? ORDER BY comment_date";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $post_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $comments = $result->fetch_all(MYSQLI_ASSOC);
            if(!$comments){
                echo "No comments yet";
            }
            else{
                foreach($comments as $comment){
                    $comment_id = $comment["comment_id"];
                    $com = $comment["comment"];
                    $comment_date = $comment["comment_date"];
                    $username = $comment["username"];

                    echo "@$username     $comment_date<br>";
                    echo "$com<br>";
                    if($username === $_SESSION["username"]){
                        echo "<form action='includes/delete_comment.inc.php' method='POST'>";
                        echo "<input type='hidden' name='comment_id' value='$comment_id'>";
                        echo "<input type='hidden' name='post_id' value='$post_id'>";
                        echo "<input type='submit' name='submit' value='Delete'>";
                        echo "</form>";
                    }
                    echo "<hr>";
                }
            }
        }

    ?>
    <form action="includes/handle_comment.inc.php" method="POST">
        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
        <textarea name="comment" placeholder="Add a comment..." required></textarea>
        <br><br>
        <input type="submit" name="submit" value="Comment">
    </form>
    <br>
    <a href="home.php">Posts</a>
</body>
</html>