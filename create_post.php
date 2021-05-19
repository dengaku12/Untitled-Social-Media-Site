<?php 
    include "includes/handle_create_post.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/mystyle.css">
    <title>Create Post</title>
</head>
<body>
    <h2>Create A New Post</h2>
    <form action="create_post.php" method="POST"  enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="500000">
        <label for="title">Post Title: </label>
        <input type="text" name="title" placeholder="Title here">
        <small>
            <?php echo (isset($errors["title"])) ? $errors["title"] : ""; ?>
        </small>
        <br><br>
        <textarea name="description" placeholder="What's poppin?"></textarea>
        <small>
            <?php echo (isset($errors["description"])) ? $errors["description"] : ""; ?>
        </small>
        <br><br>
        <label for="photo">Upload image: </label>
        <input type="file" name="photo"><br><br>
        <input type="submit" name="submit" value="Create Post">
    </form>
    <br>
    <a href="home.php">Posts</a>
</body>
</html>