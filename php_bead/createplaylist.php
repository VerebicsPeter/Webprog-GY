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

function is_empty($input, $key)
{
    return !(isset($input[$key]) && trim($input[$key]) !== "");
}

function validate($input, &$errors)
{
    if (is_empty($input, "pname")){
        $errors[] = "You must enter the playlist name!";
    }
    if (!isset($_SESSION['tracks']) || count($_SESSION['tracks']) === 0){
        $errors[] = "No tracks added!";
    }

    return !(bool) $errors;
}

$errors = [];
if (count($_POST) != 0) {
    if (!isset($_SESSION['tracks'])
        && isset($_POST['tracks'])){
        $_SESSION['tracks'] = $_POST['tracks'];
    }
    else
    if (isset($_POST['tracks'])){
        array_push($_SESSION['tracks'], ...$_POST['tracks']);
    }
    else
    if (isset($_POST['clear'])){
        $_SESSION['tracks'] = [];
    }
    else
    if (isset($_POST["create"])){
        if (validate($_POST, $errors)) {
            $is_public = isset($_POST['is_public']) && $_POST['is_public'] === "on"
            ? "true" : "false";
            $plist_repository->add(new Playlist($_POST['pname'], $_SESSION['user'], $is_public, $_SESSION['tracks']));
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
    <title>Listify - Create Playlist</title>
    <!-- ajax search scrip-->
    <script>
        $(document).ready(function(){
            $('#search').on('keyup', function() {
                let searchValue   = $(this).val();
                let categoryValue = $('#category').val();
                $.ajax({
                    url: 'searchcreate.php', type:'GET',
                    data: { search: searchValue, category: categoryValue },
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
        <h2>Create Playlist</h2>
        <form action="" method="post" novalidate>
            <input class="mb-4 btn btn-primary" type="submit" name="create" value="Create playlist">
            <input class="mb-4 btn btn-secondary" type="submit" name="clear" value="Clear tracks">
            
            <?php
            echo '<table class="table table-striped table-sm border w-90">
                    <thead>
                    <tr>
                        <th scope="col" class="col-6">Title</th>
                        <th scope="col" class="col-6">Artist</th>
                    </tr>
                    </thead>';
            if (isset($_SESSION['tracks'])) {
                foreach ($_SESSION['tracks'] as $trackid) {
                    $track = $track_repository->get_track_by_id($trackid);
                    echo '<tr>';
                    echo '<td>'.$track->title.'</td>';
                    echo '<td>'.$track->artist.'</td>';
                    echo '</tr>';
                }}
            echo '</table>';
            ?>

            <div class="mt-4">
            <label for="pname" class="ms-2">Playlist name:</label><br>
            <input id="pname" name="pname" type="text" class="m-2"
            value="<?php if (isset($_POST['pname'])) echo $_POST['pname'] ?>"><br>

            <input id="is_public" name="is_public" type="checkbox" class="m-2"><label for="is_public">Public</label><br>
            </div>
        </form>
        </div>
        <div class="col">
            <h2>Tracks</h2>
            <div class="input-group">
                <form onsubmit="event.preventDefault();" autocomplete="off">
                <div class="input-group w-90">
                    <input id="search" type="text" placeholder="find a track by" class="form-control" novalidate>
                    <select id="category" class="form-select">
                        <option value="title">title</option>
                        <option value="artist">artist</option>
                        <option value="genres">genres</option>
                    </select>
                </div>
                </form>
            </div>
            <div id="tracks" class="mt-2">
                <!--container for ajax search-->
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
    </section>
    <hr>
</body>
</html>