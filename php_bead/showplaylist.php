<?php

require_once "classes/auth.php";
require_once "classes/user.php";
require_once "classes/track.php";
require_once "classes/playlist.php";

session_start();
$auth = new Auth();

$plist_repository = new PlaylistRepository();
$track_repository = new TrackRepository();

$playlist; $playlist_length = 0;
$tracks;

if (count($_GET) != 0)
{
    $playlist = $plist_repository->get_playlist_by_id($_GET['id']);
    foreach ($playlist->tracks as $track_id) {
        $track = $track_repository->get_track_by_id($track_id);
        $tracks[$track_id] = $track;
        $playlist_length += intval($track->length);
    }
}
// only public playlists can be viewed by guests
if (!$auth->is_authenticated() && !($playlist->public === 'true')) {header('Location: index.php'); die();}

$editable = false;
if (isset($_SESSION['user']))
    $editable = $_SESSION['user'] === $playlist->creator || $auth->is_admin($_SESSION['user']);
?>

<html>
<head>
    <!--Bootstrap-5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listify - Playlist</title>
</head>
<body>
    <article style="padding: 10px; border: 1px solid black; width: 75%;">
        <h2><?=$playlist->name?></h2>
        <div style="margin-top: 10px;">
        <hr>
        <span>length:<?=gmdate("H:i:s", $playlist_length)?></span><br>
        <h3>Tracks:</h3>
        <?php
            foreach ($tracks as $track) {
                echo $track->title.' - '.$track->artist.'<br>';
            }
        ?>
        </div>
        <hr>
        <?php 
            if ($editable) echo '<a href="editplaylist.php">Edit Playlist</a>'
        ?>
        <span>created by: <?=$playlist->creator?> </span>
    </article>
    <a href="index.php">Home</a>
</body>
</html>