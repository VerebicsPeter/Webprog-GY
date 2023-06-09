<?php

require_once "classes/auth.php";
require_once "classes/user.php";
require_once "classes/track.php";
require_once "classes/playlist.php";

session_start();
$auth = new Auth();

$plist_repository = new PlaylistRepository();
$track_repository = new TrackRepository();

$is_admin; $admin_string = '';
$email; 
$email_string = '';

if (isset($_SESSION['user']))
{
    $is_admin = $auth->is_admin(); // admin privliges
    $admin_string = $is_admin ? '(admin)' : '(user)';
    $email = $auth->get_email_of($_SESSION['user']); // email string
    $email_string = isset($email)
    ? '<span>Email address: <u>'.$email.'</u></span>' : "<span>No email address provided.</span>";
}

$playlists = isset($is_admin) && $is_admin
    ? $plist_repository->all()
    : array_filter($plist_repository->all(), function ($playlist) {
        if (isset($_SESSION['user'])) return $playlist->public === 'true' || $playlist->creator === $_SESSION['user'];
        return $playlist->public === 'true';
    });

if (isset($_SESSION['tracks'])) unset($_SESSION['tracks']); // unset if set
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
    <title>Listify - Home</title>
    <!-- ajax search scrip-->
    <script>
        $(document).ready(function(){
            $('#search').on('keyup', function() {
                let searchValue = $(this).val();
                let categoryValue = $('#category').val();
                $.ajax({
                    url: 'search.php', type:'GET',
                    data: { search: searchValue, category: categoryValue },
                    success: function(response) {$('#tracks').html(response);}
                });
            });
        });
    </script>
</head>
<body>
    <section id="title" class="container">
        <h1><a class="navbar-brand" href="index.php">Listify</a></h1>
    </section>

    <hr>

    <section id="about" class="container">
        <p class="w-75">Welcome to <b>Listify</b>! Listify is a simple webapp made with stock php, where you can create your own music playlists and browse the playlists created by other users or search for tracks in the library of the app.</p>
    </section>

    <hr>

    <section id="user" class="container">
    <div class="row">
        <div class="col">
        <?php if ($auth->is_authenticated()) {?>
            <h2>Logged in as 
            <?php echo $_SESSION["user"]; ?>.
            <span class="text-secondary"><?php echo $admin_string; ?></span>
            </h2>
            <?php echo $email_string; ?>
            <br>
        <a class="mt-1" href="logout.php">Log out</a>
        <?php }?>
        <?php if (!$auth->is_authenticated()) {?>
            <h2>Browsing as guest.</h2>
            <a class="mt-1" href="login.php">Log in</a>
        <?php }?>
        </div>
        <!--create new playlist column-->
        <div class="col">
        <?php if ($auth->is_authenticated()) {?>
            <h2>New playlist</h2>
            Create a new playlist!<br>
            <a class="mt-1" href="createplaylist.php">New playlist</a>
        <?php }?>
        </div>
    </div>
    </section>
    
    <hr>

    <section id="searchbar" class="container">
    <div class="row">
        <div class="col">
        <h2>Search for a track</h2>
        <form onsubmit="event.preventDefault();" autocomplete="off" novalidate>
            <div class="input-group w-75">
                <div class="grid">
                    <div class="row">
                        <div class="col-8">
                            <input id="search" type="text" placeholder="find a track by" class="form-control">
                        </div>
                        <div class="col-4">
                        <select id="category" class="form-select">
                            <option value="title">title</option>
                            <option value="artist">artist</option>
                            <option value="genres">genres</option>
                        </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        </div>
        <div class="col">
        <?php if ($auth->is_authenticated() && $is_admin) {?>
            <div class="row">
                <div class="col-6">
                <h2>New Track</h2>
                Add a new track!<br>
                <a class="mt-1" href="addtrack.php">New track</a>
                </div>
                <div class="col-6">
                <h2>Edit Tracks</h2>
                Edit existing tracks!<br>
                <a class="mt-1" href="edittracks.php">Edit tracks</a>
                </div>
            </div>
        <?php }?>
        </div>
    </div>
    <div id="tracks" class="container">
        <!--container for ajax search-->
    </div>
    </section>
    
    <hr>

    <section id="playlists" class="container">
    <h2>Playlists</h2>
    <?php foreach ($playlists as $playlist) {?>
        <article class="media border border-secondary border-2 rounded-3 w-75 mb-2 p-3">
        <h3><?=$playlist->name?></h3>
        <div class="mt-1">
            <b>Tracks:</b>
            <?php
                $tracks = (array) $playlist->tracks; echo count($tracks);
            ?>
        </div>
        <span>created by: <?=$playlist->creator?></span><br>
        <a href=<?='showplaylist.php?id='.$playlist->_id?> class="mt-1">View</a>
        </article>
    <?php }?>
    </section>

    <hr>
</body>
</html>
