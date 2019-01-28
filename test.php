<?php
require('model.php');

// génération aléatoire du numero de plaque des véhicules

$db = dbconnect();

for($i=1; $i<288; $i++){

$char = 'abcdefghijklmnopqrstuvwxyz';
$lettre1 = str_shuffle($char);
$lettre1 = substr($lettre1, 0 , 2);

$char = '0123456789';
$numero = str_shuffle($char);
$numero = substr($numero, 0 , 3);

$char = 'abcdefghijklmnopqrstuvwxyz';
$lettre2 = str_shuffle($char);
$lettre2 = substr($lettre2, 0 , 2);

$lettre1 = mb_strtoupper($lettre1);
$lettre2 = mb_strtoupper($lettre2);

$plaque= $lettre1.$numero.$lettre2;


$insert_plaque = $db->prepare('UPDATE Car SET Ima_Car=:Ima_Car WHERE Num_Car=:Num_Car');
$insert_plaque->execute([
	'Ima_Car' => $plaque,
	'Num_Car' => $i
]);

}
echo 'ok';
