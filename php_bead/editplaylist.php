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
            unset($_SESSION['tracks']);
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listify - Edit Playlist</title>
    <!-- ajax search scrip-->
    <script>
        $(document).ready(function(){
            $('#search').on('input', function() {
                let searchValue = $(this).val();
                $.ajax({
                    url: 'searchedit.php', type:'GET',
                    data: { search: searchValue },
                    success: function(response) {$('#tracks').html(response);}
                });
            });
        });
    </script>
</head>
<body>
    <section class="container mt-2">
    <div class="row">
        <div class="col">
            <h2>Edit Playlist</h2>
            <form action="" method="post" class="mb-4">
                <input class="mt-2 btn btn-primary" type="submit" name="edit" value="Edit playlist">
                <input class="mt-2 btn btn-secondary" type="submit" name="clear" value="Clear tracks">
            </form>
            <?php
                echo '<table class="table table-striped table-sm border w-90">
                        <thead>
                        <tr>
                            <th scope="col" class="col-6">Title</th>
                            <th scope="col" class="col-6">Artist</th>
                        </tr>
                        </thead>';
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
        </div>
        <div class="col">
            <h2>Tracks</h2>
            <div class="input-group">
                <form onsubmit="event.preventDefault();" autocomplete="off" class="mt-2">
                    <input autocomplete="off" id="search" type="text" placeholder="search for a track's title ..." class="form-control">
                </form>
            </div>
            <div id="tracks" class="mt-2">
                <!--container for ajax search-->
            </div>
        </div>
    </div>
    </div>

    <?php if ($errors) {?>
    <hr>
    <ul>
        <?php foreach ($errors as $error) {?>
        <li><?=$error?></li>
        <?php }?>
    </ul>
    <hr>
    <?php }?>
    </section>
    
    <hr>
    <section class="container">
        <a href="index.php" class="m-2">Home</a>
        <a href=<?='showplaylist.php?id='.$playlist->_id?> class="m-2">Playlist</a>
    </section>
    <hr>
</body>
</html>
