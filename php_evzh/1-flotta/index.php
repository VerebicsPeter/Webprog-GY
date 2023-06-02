<?php

$shiptypes = array(
    0 => "fighter", 1 => "bomber", 2 => "frigate", 3 => "battleship", 4 => "transport");

$launched = false;

$pilotname = $_GET['pilotname'] ?? "";
$shiptype = $_GET['shiptype'] ?? "";
$crewsize = $_GET['crewsize'] ?? "";
$flying = $_GET['flying'] ?? "";

$errors = [];
if (count($_GET) > 0) {
    $errors = [];

    if (trim($pilotname) === "")
        $errors['pilotname'] = "A név megadása kötelező!";

    if ($shiptype === "")
        $errors['shiptype'] = "A típus megadása kötelező!";
    else if (!in_array($shiptype, $shiptypes))
        $errors['shiptype'] = "A megadott típus nem létezik!";

    if (trim($crewsize) === "")
        $errors['crewsize'] = "A legénység méretének megadása kötelező!";
    else if (filter_var($crewsize,FILTER_VALIDATE_INT) === false)
        $errors['crewsize'] = "A legénység mérete csak egész szám lehet!";
    else if ((int)$crewsize < 1)
        $errors['crewsize'] = "A legénység mérete legyen legalább 1!";
    else if ($shiptype === "fighter" && (int)$crewsize > 1)
        $errors['crewsize'] = "Vadászgépbe legfeljebb 1 személy fér!";
    else if ($shiptype === "bomber" && (int)$crewsize > 2)
        $errors['crewsize'] = "Bombázóba legfeljebb 2 személy fér!";
    
    if (!isset($_GET['flying']) || $_GET['flying'] !== "on")
        $errors['flying'] = "A hajónak fell kell szállnia!";

    if (count($errors) == 0) {
        $launched = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/index.css">
    <title>1. feladat - Flotta</title>
</head>
<body>
    <h1>1. feladat - Flotta</h1>
    <div id="introduction">
        <img src="src/character.png">
        <span>Segíts összeszednem a flottát a támadáshoz!</span>
    </div>

    <h2>Hajó hozzáadása</h2>
    <form method="get" novalidate>
        <label for="pilotname">Pilóta/kapitány neve</label>
        <input name="pilotname" value="<?= $_GET['pilotname'] ?? "" ?>">
        
        <br>
        
        <label for="shiptype">Hajó típusa</label>
        <select name="shiptype">
            <option value="fighter"    <?php if ($_GET['shiptype'] === "fighter")    echo 'selected'; ?>>Vadász</option>
            <option value="bomber"     <?php if ($_GET['shiptype'] === "bomber")     echo 'selected'; ?>>Bombázó</option>
            <option value="frigate"    <?php if ($_GET['shiptype'] === "frigate")    echo 'selected'; ?>>Fregatt</option>
            <option value="battleship" <?php if ($_GET['shiptype'] === "battleship") echo 'selected'; ?>>Csatahajó</option>
            <option value="transport"  <?php if ($_GET['shiptype'] === "transport")  echo 'selected'; ?>>Szállító</option>
        </select>

        <br>

        <label for="crewsize">Legénység mérete</label>
        <input name="crewsize" value="<?= $_GET['crewsize'] ?? "" ?>">
        
        <br>

        <label for="flying">Felszállt a hajó?</label>
        <span><input name="flying" type="checkbox" <?php if (isset($_GET['flying']) && $_GET['flying'] === "on") echo 'checked'; ?>>
        Igen, felszállt
        </span>

        <br>

        <input type="submit" value="Felszállás">
    </form>
    <?php if (count($errors) > 0): ?>
    <div id="errors">
        <h2>Hiba a hajó flottához adásakor!</h2>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <?php if ($launched): ?>
    <div id="success">
        <h2>Hajó sikeresen a flottához adva!</h2>
        <img src="src/success.png">
    </div>
    <?php endif; ?>
    <div>
        <h2>Ezekkel a linkekkel könnyű tesztelni</h2>
        Ha nem az index.php oldalon végzed az ellenőrzést, a teszteléshez át kell írnod a linkekben az index.php-t.
        <ul>
            <li><a href="index.php?pilotname=&shiptype=&crewsize=">❌pilotname ❌shiptype ❌crewsize ❌flying</a></li>
            <li><a href="index.php?pilotname=Wedge Antilles&shiptype=cruiser&crewsize=1">✅pilotname ❌shiptype ✅crewsize ❌flying</a></li>
            <li><a href="index.php?pilotname=Wedge Antilles&shiptype=fighter&crewsize=2">✅pilotname ✅shiptype ❌crewsize ❌flying</a></li>
            <li><a href="index.php?pilotname=Jon Vander&shiptype=bomber&crewsize=3&flying=on">✅pilotname ✅shiptype ❌crewsize ✅flying</a></li>
            <li><a href="index.php?pilotname=Admiral Raddus&shiptype=battleship&crewsize=1500">✅pilotname ✅shiptype ✅crewsize ❌flying</a></li>
            <li><a href="index.php?pilotname=Admiral Raddus&shiptype=battleship&crewsize=1500&flying=on">✅pilotname ✅shiptype ✅crewsize ✅flying</a></li>
        </ul>
    </div>
</body>
</html>