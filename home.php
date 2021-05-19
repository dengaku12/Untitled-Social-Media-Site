<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style/mystyle.css">
    <title>Home</title>
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
        
        $query = "SELECT post_id, title, description, image, post_date, username FROM posts, users ";
        $query .= "WHERE user_id_fk = user_id ORDER BY post_id DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        $posts = $result->fetch_all(MYSQLI_ASSOC);
        if(!$posts) exit("No Posts yet");

        echo "<h1>Welcome back, ".$_SESSION["username"];
        echo "</h1>";
        echo "Not you? <a href='logout.php'>Logout</a><br>";
        echo "<a href='create_post.php'><button>Create a Post</button></a><br><br><br><hr>";
        foreach($posts as $post){
            $post_id = $post["post_id"];
            $title = $post["title"];
            $desc = $post["description"];
            $image = $post["image"];
            $post_date = $post["post_date"];
            $username = $post["username"];
            
            echo "<b>$title</b><br>@$username $post_date";
            echo "<p>$desc</p>";
            if(!!$image){
                echo "<img src='$image' width='400'><br>";
            }
            echo "<a href='comments.php?post_id=$post_id'><button>Comments</button></a>  ";
            if($username === $_SESSION["username"]){
                echo "<form action='includes/delete_post.inc.php' method='POST'>";
                echo "<input type='hidden' name='post_id' value='$post_id'>";
                echo "<input type='submit' name='submit' value='Delete'>";
                echo "</form>";
            }
            echo "<br><hr>";
            
        }
        

    ?>
</body>
</html>
