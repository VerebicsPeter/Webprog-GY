<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $num = 6;
    function fact(int $x)
    {
        if ($x <= 1) {
            return 1;
        } else {
            return $x * fact($x - 1);
        }
    }

    echo "$num! is " . fact($num);
    ?>
</body>
</html>