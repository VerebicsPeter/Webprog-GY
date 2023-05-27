<?php

require_once "classes/auth.php";
require_once "classes/user.php";
require_once "classes/track.php";
require_once "classes/playlist.php";

session_start();
$auth = new Auth();

$playlist_repository = new PlaylistRepository();

$is_admin;
$admin_string = '';
$email;
$email_string = '';

if (isset($_SESSION['user']))
{
    $is_admin = $auth->is_admin($_SESSION['user']); // admin privliges
    $admin_string = $is_admin ? '(admin)' : '(user)';
    $email = $auth->get_email_of($_SESSION['user']); // email string
    $email_string = isset($email)
    ? '<span>Email address: <u>'.$email.'</u></span>' : "<span>No email address provided.</span>";
}

?>

<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listify - Home</title>
</head>
<body>
    <h1>Listify</h1>

    <p>Welcome to <b>Listify</b>! Listify is a basic webapp made with stock php, where you can create your own music playlists and browse the playlists created by other users or search for playlists containing your favourite tracks.</p>

    <hr style="width:100%">

    <?php if ($auth->is_authenticated()) {?>
        <h2>Logged in as 
        <?php echo $_SESSION["user"]; ?>
        <?php echo $admin_string; ?>.
        </h2>
        <?php echo $email_string; ?>
        <br>
        <a href="logout.php">Logout</a>
    <?php }?>
    <?php if (!$auth->is_authenticated()) {?>
        <h2>Logged in as guest.</h2>
        <a style="padding: 5px;" href="login.php">Login</a>
    <?php }?>
    
    <hr style="width:100%">

    <h2>Playlists</h2>
    <!--TODO: proper filtering-->
    <?php foreach ($playlist_repository->all() as $playlist) {?>
        <article style="padding: 10px; border: 1px solid black; width: 75%;">
        <h3><?=$playlist->name?></h3>
        <div style="margin-top: 10px;">
        <b>Tracks:</b>
        <?php
        $tracks = (array) $playlist->tracks; echo count($tracks);
        ?>
        </div>
        <span>created by: <?=$playlist->creator?></span>
        <br>
        <button style="margin-top: 10px;">
            View
        </button>
        </article>
    <?php }?>
</body>
</html>
