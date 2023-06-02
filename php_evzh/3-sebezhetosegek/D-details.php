<?php

include_once "classes/vulnerability.php";

$vulnerability_store = new VulnerabilityStorage();

$vulnerability;

if (count($_GET) > 0) {
    if (isset($_GET['id'])) $vulnerability = $vulnerability_store->get_by_id($_GET['id']);
}

if (!isset($vulnerability)) header('Location: index.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/index.css">
    <title>3. Feladat - Sebezhetőségek</title>
</head>
<body>
    <h1>3. Feladat - Sebezhetőségek</h1>
    <div id="introduction">
        <img src="src/character.png">
        <span>Oh, remek, ez egy sebezhetőség!</span>
    </div>

    <h2><?= $vulnerability->shortdesc.'('.$vulnerability->danger.')' ?></h2>
    <div id="vulnerability">
        <img src="<?= $vulnerability->image ?>">
        <span>
            <?=$vulnerability->longdesc?>
        </span>
    </div>
    
    <a href="index.php">Vissza a listához</a>
    
    <h2>Szerkesztés</h2>
    <form method="post" action="E-edit.php" novalidate>
        <input type="hidden" name="id" value="<?=$vulnerability->_id?>">

        <label for="shortdesc">Rövid név</label>
        <input name="shortdesc" value="<?=$vulnerability->shortdesc ?? ""?>">
        
        <br>
        
        <label for="danger">Komolyság</label>
        <input name="danger" type="number" min="1" max="5" value="<?=(int) $vulnerability->danger ?? 0?>">

        <br>

        <label for="longdesc">Leírás</label>
        <textarea name="longdesc"><?= $vulnerability->longdesc ?? "" ?></textarea>

        <br>

        <label for="image">Kép</label>
        <input name="image" value="<?= $vulnerability->image ?? "" ?>">

        <input type="submit" value="Sebezhetőség szerkesztése">
    </form>
</body>
</html>