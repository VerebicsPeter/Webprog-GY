<?php

require_once "classes/auth.php";
require_once "classes/user.php";
require_once "classes/track.php";


session_start();
$auth = new Auth();

$track_repository = new TrackRepository();

if (!($auth->is_authenticated() && $auth->is_admin())) {
    header('Location: index.php'); die();
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
    <title>Listify - Add Track</title>
</head>
<body>
    <section class="container mt-2">
    <h2>Edit Tracks</h2>
    
    <?php foreach ($track_repository->all() as $track) {?>
        <div class="row border w-75">
            <div class="col-6">
                <?=$track->title?>
            </div>
            <div class="col-5">
                <?=$track->artist?>
            </div>
            <div class="col-1 text-end">
                <a href="edittrack.php?id=<?=$track->_id?>">edit</a>
            </div>
        </div>
    <?php }?>

    </section>
    <hr>
    <section class="container">
        <a href="index.php" class="m-2">Home</a>
    </section>
    <hr>
</body>
</html>