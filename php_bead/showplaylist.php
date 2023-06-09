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

if (count($_GET) != 0) {
    $count = 0;
    $playlist = $plist_repository->get_playlist_by_id($_GET['id']);
    foreach ($playlist->tracks as $track_id) {
        $track = $track_repository->get_track_by_id($track_id);
        $tracks[$count] = $track; $count++;
        $playlist_length += intval($track->length);
    }
}
// only public playlists can be viewed by guests
if (!$auth->is_authenticated() && !($playlist->public === 'true')) {header('Location: index.php'); die();}

$editable = false;
if (isset($_SESSION['user']))
    $editable = $_SESSION['user'] === $playlist->creator || $auth->is_admin($_SESSION['user']);

if (isset($_SESSION['tracks'])) unset($_SESSION['tracks']); // unset if set
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
    <section class="container mt-2">
    <article class="border border-secondary border-2 rounded-3 mb-2 p-4">
        <h2><?=$playlist->name?></h2>
        <div class="mt-2">
        <hr>
        <span>created by: <b><?=$playlist->creator?></b></span>
        <?php echo ', '.count($tracks).' tracks , '; ?>
        <?php if ($playlist_length / 360 > 0): ?>
            <span><?= (intdiv($playlist_length, 60)).'m '.($playlist_length % 60).'s' ?></span><br>
        <?php else : ?>
            <span><?= (intdiv($playlist_length, 360)).'h '.(intdiv($playlist_length, 60)).'m '.($playlist_length % 60).'s' ?></span><br>
        <?php endif; ?>
        <hr>
        <h3>Tracks</h3>
        <?php
            echo '<table class="table table-striped border">
                    <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Artist</th>
                        <th scope="col">Genres</th>
                        <th scope="col">Length</th>
                        <th scope="col">Year</th>
                    </tr>
                    </thead>';
            foreach ($tracks as $track) {
                echo '<tr>';
                echo '<td>'.$track->title.'</td>';
                echo '<td>'.$track->artist.'</td>';
                echo '<td>'.$track->get_genre_string().'</td>';
                echo '<td>'.gmdate("i:s", intval($track->length)).'</td>';
                echo '<td>'.$track->year.'</td>';
                echo '</tr>';
            }
            echo '</table>';
        ?>
        </div>
        <hr>
        <?php 
            if ($editable) echo '<a href="editplaylist.php?id='.$playlist->_id.'">Edit Playlist</a>'
        ?>
    </article>
    </section>
    
    <hr>
    <section class="container">
        <a href="index.php" class="m-2">Home</a>
    </section>
    <hr>
</body>
</html>