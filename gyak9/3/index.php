<?php
function validate($input)
{
    if (!ctype_xdigit($input) || strlen($input) != 6) { // Hex color ellenőrzése
        return true;
    } 

    return false;
}

$error = false;

// validate
if (isset($_GET["color"])) {
    $error = validate($_GET["color"]);
    if (!$error) {
        // input
        $color = $_GET["color"];
    }
} else {
    $color = "ffffff";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>



<body style="background-color: #<?=$color?>;">
    <ul>
        <?php
            if($error)
                echo "<li>Hibás színkód!</li>";
        ?>
    </ul>
        <ul>
            <li><a href="?color=00bbff">kék</a></li>
            <li><a href="?color=ffff44">sárga</a></li>
            <li><a href="?color=ff4444">piros</a></li>
        </ul>

        <form action="" method="get">
            <label for="color">Color: </label>
            <input type="text" name="color" value="ffffff">
            <button type="submit">Send</button>
        </form>

</body>

</html>