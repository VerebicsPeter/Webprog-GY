<?php

require_once "classes/auth.php";
require_once "classes/user.php";
require_once "classes/track.php";
require_once "classes/playlist.php";

session_start();
$auth = new Auth();

$plist_repository = new PlaylistRepository();
$track_repository = new TrackRepository();

// only logged in users can add new playlists
if (!$auth->is_authenticated()) {
    header('Location: login.php'); die();
}

$playlist;
if (isset($_GET['id']))
{
    $playlist = $plist_repository->get_playlist_by_id($_GET['id']);
    if (!isset($_SESSION['tracks'])) {
        $_SESSION['tracks'] = $playlist->tracks;
        $_SESSION['tracks'] = (array)$_SESSION['tracks']; // gets set as object without type cast
    }
}

function validate(&$errors)
{
    if (count($_SESSION['tracks']) === 0){
        $errors[] = "No tracks added!";
    }
    return !(bool) $errors;
}

$errors = [];
if (count($_POST) != 0) {
    if (isset($_POST['add'])){
        array_push($_SESSION['tracks'], ...$_POST['add']);
    }
    if (isset($_POST['rem'])){
        $_SESSION['tracks'] = array_diff($_SESSION['tracks'], $_POST['rem']);$_POST['rem'] = [];
    }
    else
    if (isset($_POST['clear'])){
        $_SESSION['tracks'] = [];
    }
    else
    if (isset($_POST['edit'])){
        if (validate($errors)){
            $plist_repository->update_tracks($playlist, $_SESSION['tracks']);
            unset($_SESSION['tracks']); unset($_SESSION['just_started']);
            header('Location: index.php');
        }
    }
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
    <title>Listify - Edit Playlist</title>
</head>
<body>
    <section class="container mt-2">
    <h2>Edit Playlist</h2>
    <?php if ($errors) {?>
    <ul>
        <?php foreach ($errors as $error) {?>
        <li><?=$error?></li>
        <?php }?>
    </ul>
    <?php }?>
    <form action="" method="post">
        <label class="mb-2">Tracks:</label><br>
        <?php
            echo '<table class="table table-bordered table-sm w-75">
                    <tr>
                        <th scope="col" class="col-6">Title</th>
                        <th scope="col" class="col-6">Artist</th>
                    </tr>';
            if (isset($playlist->tracks) && isset($_SESSION['tracks'])) {
                foreach ($_SESSION['tracks'] as $track_id) {
                    $track = $track_repository->get_track_by_id($track_id);
                    echo '<tr>';
                    echo '<td>'.$track->title.'</td>';
                    echo '<td>'.$track->artist.'</td>';
                    echo '</tr>';
                }
            }
            echo '</table>';
        ?>

        <input class="mt-1 btn btn-sm btn-primary" type="submit" name="edit" value="Edit playlist">
        <input class="mt-1 btn btn-sm btn-secondary" type="submit" name="clear" value="Clear tracks">
    </form>
    </section>
    <hr>
    <section class="container mt-2">
    <h2>Tracks:</h2>
    <?php
            echo '<table class="table table-bordered table-sm w-75">
                    <tr>
                        <th scope="col" class="col-6">Title</th>
                        <th scope="col" class="col-6">Artist</th>
                        <th scope="col" class="col-1">Add</th>
                        <th scope="col" class="col-1">Remove</th>
                    </tr>';
            $arr = $track_repository->all();
            usort($arr, function ($a, $b) {return strcmp($a->title, $b->title);});
            foreach ($arr as $track) {
                echo '<tr>';
                echo '<td>'.$track->title.'</td>';
                echo '<td>'.$track->artist.'</td>';
                echo '<td>';
                echo '<form method="POST" action="">';
                echo '<input type="hidden" name="add[]" value="'.$track->_id.'">';
                echo '<input type="submit" value="Add" class="btn btn-sm btn-primary">';
                echo '</form>';
                echo '</td>';
                echo '<td>';
                echo '<form method="POST" action="">';
                echo '<input type="hidden" name="rem[]" value="'.$track->_id.'">';
                echo '<input type="submit" value="Remove" class="btn btn-sm btn-secondary">';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</table>';
        ?>
    </section>
    <hr>
    <section class="container">
        <a href="index.php" class="m-2">Home</a>
        <a href=<?='showplaylist.php?id='.$playlist->_id?> class="m-2">Back</a>
    </section>
    <hr>
</body>
</html>
