<?php

/*
Tároljuk az autók adatait json formátumban!
    Használjuk a megadott JsonStorage osztályt: alap.zip
    Készítsünk el egy autok.json fájlt legalább 2 minta autóval 1 pont
    Töltsük be az autok.json fájlt egy JsonStorage objektumba 0.5 pont
    Készítsünk egy objektumot az űrlap bemenete alapján és adjuk hozzá a JsonStorage objektumhoz 1 pont
*/

include_once "car.php";
include_once "2.php";

$repository = new CarRepository();

foreach ($repository->all() as $car)
{
    echo $car->plate . "-"; echo $car->brand . "; ";
}

?>
