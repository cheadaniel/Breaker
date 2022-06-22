<?php

// $array = [["chiffre" => 3],["chiffre" => 45]];
// var_dump($array);


// foreach ($array as $x => $value)
// {
//   echo("$x = $value"."\n");
// }

$age = array(array("chiffre" => "35"), array("chiffre" => "37"), array("chiffre" => "43"));
var_dump($age);
$array = [];
for ($i = 0; $i < count($age); $i++) {

    array_push($array, $age[$i]['chiffre']);
}
var_dump($array);


for ($i = 0; $i < count($array); $i++) { //eviter les scores en double et enregistrer les nvx score
    if (in_array(200, $array));
    else {
        array_push($age, array("chiffre" => "200"));
        break;
    }
}
var_dump($array);
var_dump($age);
