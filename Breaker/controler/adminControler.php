<?php

//var_dump($_SESSION);

require_once 'model/UserPDO.php';

$getNonAdminUser = $pdo->prepare(' SELECT `id`,`name`,`admin`  FROM `user` WHERE `admin` =  0 '); //recupere le tableau user des joueurs non admin, on prend id name et admin
$getNonAdminUser->execute(); //
$nonAdminUser = $getNonAdminUser->fetchAll();
//var_dump($nonAdminUser);




$getScore = $pdo->prepare(' SELECT *  FROM `score`'); // recupere le tableau de score
$getScore->execute(); //
$nonAdminUserScore = $getScore->fetchAll();
//var_dump($nonAdminUserScore);

$getMessage = $pdo->prepare(' SELECT `text`,`id_user`,`id`  FROM `message`'); //recupere le tableau message avec id du message son texte et l'id du joueur qui la envoyé
$getMessage->execute(); //
$nonAdminUserMessage = $getMessage->fetchAll();
//var_dump($nonAdminUserMessage);
