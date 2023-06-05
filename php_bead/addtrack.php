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

function is_empty($input, $key)
{
    return !(isset($input[$key]) && trim($input[$key]) !== "");
}

function validate($input, &$errors)
{
    if (is_empty($input, "title") ||
        is_empty($input, "artist")||
        is_empty($input, "length")||
        is_empty($input, "genres")||
        is_empty($input, "year")){
        $errors[] = "You must fill in all of the fields!";
    }
    else
    if (!is_numeric($input['length'])){
        $errors[] = "Length must be a numeric value!";
    }
    else
    if (!is_numeric($input['year']) || !(strlen($_POST['year'])===4)){
        $errors[] = "Year format is wrong!";
    }

    return !(bool) $errors;
}

$errors = [];
if (count($_POST) != 0){
    if (validate($_POST, $errors)){
        $genres = explode(", ", $_POST['genres']);
        $track_repository->add(new Track($_POST['title'], $_POST['artist'], $_POST['length'], $_POST['year'], $genres));
        header('Location: index.php');
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
    <title>Listify - Add Track</title>
</head>
<body>
    <section class="container mt-2">
    <h2>Add track</h2>
    
    <form action="" method="post" novalidate>
        <label for="title">Track title:</label><br>
        <input id="title" name="title" type="text" value="<?php if (isset($_POST['title'])) echo $_POST['title'] ?>"><br>

        <label for="artist">Track artist:</label><br>
        <input id="artist" name="artist" type="text" value="<?php if (isset($_POST['artist'])) echo $_POST['artist'] ?>"><br>
        
        <label for="length">Track length:</label><br>
        <input id="length" name="length" type="text" placeholder="in seconds" value="<?php if (isset($_POST['length'])) echo $_POST['length'] ?>"><br>

        <label for="year">Track year:</label><br>
        <input id="year" name="year" type="year" placeholder="YYYY" value="<?php if (isset($_POST['year'])) echo $_POST['year'] ?>"><br>
        
        <label for="genres">Track genres:</label><br>
        <input id="genres" name="genres" type="genres" placeholder="pop, dance, ..." value="<?php if (isset($_POST['genres'])) echo $_POST['genres'] ?>"><br>

        <input class="mt-2 btn btn-sm btn-primary" type="submit" name="addtrack" value="Add track">
    </form>

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