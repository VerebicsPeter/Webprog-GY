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
    //if (strlen($_GET['search'])) {
    $selected_tracks = $track_repository->get_tracks_by_title($_GET['search']);
    //}
}

$playlists = isset($is_admin) && $is_admin
    ? $plist_repository->all()
    : array_filter($plist_repository->all(), function ($playlist) {
        if (isset($_SESSION['user'])) return $playlist->public === 'true' || $playlist->creator === $_SESSION['user'];
        return $playlist->public === 'true';
    });

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
    <section id="title" class="container">
        <h1><a class="navbar-brand" href="index.php">Listify</a></h1>
    </section>

    <hr>

    <section id="about" class="container">
        <p>Welcome to <b>Listify</b>! Listify is a basic webapp made with stock php, where you can create your own music playlists and browse the playlists created by other users or search for playlists containing your favourite tracks.</p>
    </section>

    <hr>

    <section id="user" class="container">
    <?php if ($auth->is_authenticated()) {?>
        <h2>Logged in as 
        <?php echo $_SESSION["user"]; ?>
        <?php echo $admin_string; ?>.
        </h2>
        <?php echo $email_string; ?>
        <br>
        <a class="mt-1" href="logout.php">Logout</a>
    <?php }?>
    <?php if (!$auth->is_authenticated()) {?>
        <h2>Logged in as guest.</h2>
        <a class="mt-1" href="login.php">Login</a>
    <?php }?>
    </section>
    
    <hr>

    <section id="search_track_section" class="container">
    <h2>Search for a track</h2>
    <form action="" method="get" novalidate>
        <input id="search" name="search" type="text" placeholder="Tracks title" onkeyup="" class="w-25">
        <input type="submit" value="Search">
    </form>
    <!--TODO: use ajax to show results instead of this-->
    <div id="tracks" class="container">
        <?php
            if (isset($selected_tracks)) {
                if (count($selected_tracks) === 0)
                echo '<div class="alert alert-info">No results found.</div>';
                else {
                    echo '<table class="table table-bordered">
                            <tr>
                                <th>Title</th>
                                <th>Artist</th>
                                <th>Genres</th>
                                <th>Year</th>
                            </tr>';
                    foreach ($selected_tracks as $track) {
                        echo '<tr>';
                        echo '<td>'.$track->title.'</td>';
                        echo '<td>'.$track->artist.'</td>';
                        echo '<td>'.$track->get_genre_string().'</td>';
                        echo '<td>'.$track->year.'</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                }
            }
        ?>
    </div>
    </section>
    
    <hr>

    <section id="playlists" class="container">
    <h2>Playlists</h2>
    <!--TODO: proper filtering-->
    <?php foreach ($playlists as $playlist) {?>
        <article class="media border border-primary rounded w-75 mb-1 p-3">
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
</body>
</html>
