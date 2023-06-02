<?php



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
    <form>
        <label for="pilotname">Pilóta/kapitány neve</label>
        <input name="pilotname">
        
        <br>
        
        <label for="shiptype">Hajó típusa</label>
        <select name="shiptype">
            <option value="fighter"   >Vadász   </option>
            <option value="bomber"    >Bombázó  </option>
            <option value="frigate"   >Fregatt  </option>
            <option value="battleship">Csatahajó</option>
            <option value="transport" >Szállító </option>
        </select>

        <br>

        <label for="crewsize">Legénység mérete</label>
        <input name="crewsize">
        
        <br>

        <label for="flying">Felszállt a hajó?</label>
        <span><input name="flying" type="checkbox"> Igen, felszállt</span>

        <br>

        <input type="submit" value="Felszállás">
    </form>

    <div id="errors">
        <h2>Hiba a hajó flottához adásakor!</h2>
        <ul></ul>
    </div>

    <div id="success">
        <h2>Hajó sikeresen a flottához adva!</h2>
        <img src="src/success.png">
    </div>

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