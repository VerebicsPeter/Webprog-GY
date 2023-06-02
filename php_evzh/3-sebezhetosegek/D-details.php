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

    <h2>Példa sebezhetőség (3)</h2>
    <div id="vulnerability">
        <img src="src/error0.png">
        <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span>
    </div>
    
    <a href="index.php">Vissza a listához</a>
    
    <h2>Szerkesztés</h2>
    <form>
        <input type="hidden" name="id">

        <label for="shortdesc">Rövid név</label>
        <input name="shortdesc">
        
        <br>
        
        <label for="danger">Komolyság</label>
        <input name="danger" type="number" min="1" max="5">

        <br>

        <label for="longdesc">Leírás</label>
        <textarea name="longdesc"></textarea>

        <br>

        <label for="image">Kép</label>
        <input name="image">

        <input type="submit" value="Sebezhetőség szerkesztése">
    </form>
</body>
</html>