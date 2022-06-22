<?php 

//var_dump($_SESSION);
$pseudo = $_SESSION['name'];

require_once 'model/UserPDO.php'; //fichier qui connecte a la base de donnée
$getIdFromBDD = $pdo->prepare(' SELECT `id`  FROM `user` WHERE `name` =  :pseudo ');
$getIdFromBDD ->execute(['pseudo' => $pseudo]);
$idGet = $getIdFromBDD -> fetchAll();

$idPlayer = $idGet[0]['id']; //recupere l'id du joueur
$player = [$pseudo,$idPlayer];//stock dans l'array le pseudo et son id

$getScoreTableGlobal = $pdo->prepare(' SELECT `number`,`pseudo` FROM score ORDER BY number DESC LIMIT 10'); //recupere les 10 meilleurs score globaux
$getScoreTableGlobal->execute();
$scoreGetGlobal = $getScoreTableGlobal->fetchAll();


$getScoreTablePlayer = $pdo->prepare(' SELECT `number`,`pseudo` FROM score  WHERE `pseudo` =  :pseudo ORDER BY number DESC LIMIT 10');//recupere les 10 meilleurs score du joueurs
$getScoreTablePlayer->execute(['pseudo' => $pseudo]);
$scoreGetPlayer = $getScoreTablePlayer->fetchAll();
