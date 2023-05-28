<?php

require_once "classes/auth.php";
require_once "classes/user.php";
require_once "classes/track.php";
require_once "classes/playlist.php";

session_start();
$auth = new Auth();

$plist_repository = new PlaylistRepository();
$track_repository = new TrackRepository();

$playlist; $tracks;

if (count($_GET) != 0)
{
    $playlist = $plist_repository->get_playlist_by_id($_GET['id']);
    foreach ($playlist->tracks as $track_id) {
        $tracks[$track_id] = $track_repository->get_track_by_id($track_id);
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
    <a href="index.php">Back</a>
</body>
</html>