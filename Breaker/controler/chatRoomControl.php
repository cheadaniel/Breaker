<?php


$pseudo = $_SESSION['name'];
require_once 'model/UserPDO.php';

$getIdFromBDD = $pdo->prepare(' SELECT `id`  FROM `user` WHERE `name` =  :pseudo ');
$getIdFromBDD->execute(['pseudo' => $pseudo]);
$idGet = $getIdFromBDD->fetchAll();
$idCurrentUser = $idGet[0]['id'];
// var_dump($idGet);

$getMessageFromBDD = $pdo->prepare(' SELECT `text`, `create_at`, `id_user` FROM `message` ORDER BY create_at DESC');
$getMessageFromBDD->execute(); //['pseudo' => $pseudo]
$messageGet = $getMessageFromBDD->fetchAll();
// var_dump($messageGet);



$getIdAndNameFromUser = $pdo->prepare(' SELECT `id`,`name`  FROM `user` ');
$getIdAndNameFromUser->execute(); //['id_user' => $id_userMessage]
$IdAndNameGet = $getIdAndNameFromUser->fetchAll();
// var_dump($IdAndNameGet);

function addMessageBDD($connexion, $word1, $word2)
{
    $query = $connexion->prepare(
        "INSERT INTO `message` (text , id_user) 
        VALUES (:text,:id_user)"
    );
    $query->execute(['text' => $word1, 'id_user' => $word2]);
}

if (isset($_POST['msgContent'])) {
    // echo('je suis la ');
    $message =  htmlspecialchars($_POST['msgContent']);
    addMessageBDD($pdo, htmlspecialchars_decode($message), $idCurrentUser);
}
// else {
//     // echo'je ne marche pas ';
// }
