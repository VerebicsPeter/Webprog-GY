<?php
require_once "classes/post.php";
require_once "classes/auth.php";

session_start();
$auth = new Auth();

$repository = new PostRepository();

?>

<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>
<body>
    <h1>Index Page</h1>

    <hr style="width:100%">

    <?php if ($auth->is_authenticated()) {?>
        <h2>Welcome <?php echo $_SESSION["user"]; ?>!</h2>
        <a style="padding: 5px;" href="createpost.php">Create Post</a>
        <a style="padding: 5px;" href="logout.php">Logout</a>
    <?php }?>
    <?php if (!$auth->is_authenticated()) {?>
        <h2>Login</h2>
        <a style="padding: 5px;" href="login.php">Login</a>
    <?php }?>
    
    <hr style="width:100%">

    <h2>Posts</h2>
    <?php foreach ($repository->all() as $post) {?>
        <article style="width: 75%; border: 3px solid black; padding: 20px; margin-bottom: 10px;">
        <h3><?=$post->title?></h3>
        <p style="text-align: justify;"><?=$post->post_text?></p><br>
        <span>posted by: <?=$post->username?> @ <?=$post->post_date?></span>
        </article>
    <?php }?>
</body>
</html>