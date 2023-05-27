<?php
require_once "classes/auth.php";
require_once "classes/post.php";

session_start();
$auth = new Auth();

if (!$auth->is_authenticated()) {
    header('Location: login.php');
    die();
}

$repository = new PostRepository();

function is_empty($input, $key)
{
    return !(isset($input[$key]) && trim($input[$key]) !== "");
}
function validate($input, &$errors)
{
    if (is_empty($input, "title") || is_empty($input, "post_text")) {
        $errors[] = "Title or post content missing!";
    }
    return !(bool) $errors;
}

$errors = [];
if (count($_POST) != 0) {
if (validate($_POST, $errors)) {
    $repository->add(new Post(
        $_POST["title"], $_POST["post_text"],
        date("Y.m.d H:i"), $_SESSION["user"],
        )
    );
}}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
</head>

<body>
    <h2>Create Post</h2>
    <?php if ($errors) {?>
    <ul>
        <?php foreach ($errors as $error) {?>
        <li><?=$error?></li>
        <?php }?>
    </ul>
    <?php }?>
    <form action="" method="post">
        <label for="title">Title:</label><br>
        <input id="title" name="title" type="text"><br>
        <label for="post_text">Text:</label><br>
        <textarea id="post_text" name="post_text" rows="5" cols="50" style="margin-bottom: 10px;" placeholder="post content"></textarea>
        <br>
        <input type="submit" value="Post">
    </form>
    <a href="index.php">Posts</a>
</body>
</html>
