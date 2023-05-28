<?php

require_once "classes/auth.php";
require_once "classes/user.php";
require_once "classes/track.php";
require_once "classes/playlist.php";

session_start();
$auth = new Auth();

$plist_repository = new PlaylistRepository();
$track_repository = new TrackRepository();

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

$selected_tracks;
if (count($_GET) != 0) {
    $selected_tracks = $track_repository->get_tracks_by_title($_GET['search']);
}
?>

<html>
<head>
    <!--Bootstrap-5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listify - Home</title>
</head>
<body>
    <h1>Listify</h1>

    <section id="about">
        <p>Welcome to <b>Listify</b>! Listify is a basic webapp made with stock php, where you can create your own music playlists and browse the playlists created by other users or search for playlists containing your favourite tracks.</p>
    </section>

    <hr style="width:100%">

    <section id="user">
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
    </section>
    
    <hr style="width:100%">

    <section id="track_search">
    <form action="" method="get" novalidate>
        <input id="search" name="search" type="text" placeholder="search" onkeyup="">
        <input style="margin: 0px 10px 0px 10px;" type="submit" value="Search">
    </form>
    <!--TODO: use ajax to show results instead of this-->
    <div id="tracks">
        <?php
            if (isset($selected_tracks)) {
                foreach ($selected_tracks as $track) {
                    echo $track->title.' - '.$track->artist.'<br>';
                }}
        ?>
    </div>
    </section>
    
    <hr style="width:100%">

    <section id="playlists">
    <h2>Playlists</h2>
    <!--TODO: proper filtering-->
    <?php foreach ($plist_repository->all() as $playlist) {?>
        <article style="padding: 10px; border: 1px solid black; width: 75%;">
        <h3><?=$playlist->name?></h3>
        <div style="margin-top: 10px;">
        <b>Tracks:</b>
        <?php
            $tracks = (array) $playlist->tracks; echo count($tracks);
        ?>
        </div>
        <span>created by: <?=$playlist->creator?> </span>
        <br>
        <a style="margin-top: 10px;" href=<?='showplaylist.php?id='.$playlist->_id?>>View</a>
        </article>
    <?php }?>
    </section>
</body>
</html>