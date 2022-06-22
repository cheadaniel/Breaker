<?php
require_once '../model/UserPDO.php';
if ($_POST['playerNameAdmin']) $pseudo = htmlspecialchars($_POST['playerNameAdmin']); //gere les caractere spéciaux lors de l'entrée de l'input
else if ($_POST['playerNameDelete']) $pseudo = htmlspecialchars($_POST['playerNameDelete']);



$userId = $pdo->prepare('SELECT id FROM `user` WHERE name = :pseudo '); // recupère l'id du joueur dans la table user
$userId->execute(['pseudo' => htmlspecialchars_decode($pseudo)]); //
$getId = $userId->fetchAll();



if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['passerAdmin'])) { //lors du clique sur le bouton active la fonction qui permet de passer admin
    deviensAdmin($pdo, $pseudo);
}
function deviensAdmin($connexion, $word)
{ //passe le booleen a true dans la table user pour passer le joueur en admin
    $beAdmin = $connexion->prepare(' UPDATE user SET admin = 1 WHERE name = :pseudo');
    $beAdmin->execute(['pseudo' => htmlspecialchars_decode($word)]); //
    $AdminOk = $beAdmin->fetchAll();
}

if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['effacer']) && !empty($getId)) { //lors du clique sur le bouton active les fonction qui permet d'effacer l'user de la db, en 1 les messages qu'il a envoyer, en 2 ses scores et enfin son pseudo
    deletePlayerMessage($pdo, $getId[0]['id']);
    deletePlayerScore($pdo, $getId[0]['id']);
    deletePlayer($pdo, $getId[0]['id']);
}

function deletePlayerMessage($connexion, $id)
{ //efface les messages du joueur dans la table message
    $delete = $connexion->prepare(' DELETE FROM `message` WHERE id_user = :idPlayer');
    $delete->execute(['idPlayer' => $id]);
    $deleteOk = $delete->fetchAll();
}


function deletePlayerScore($connexion, $id)
{ //efface les score du joueur dans la table score
    $delete = $connexion->prepare(' DELETE FROM `score` WHERE id_user = :idPlayer');
    $delete->execute(['idPlayer' => $id]); //
    $deleteOk = $delete->fetchAll();
}

function deletePlayer($connexion, $id)
{ //efface le pseudo dans la table user
    $delete = $connexion->prepare(' DELETE FROM `user` WHERE id = :idPlayer');
    $delete->execute(['idPlayer' => $id]); //
    $deleteOk = $delete->fetchAll();
}


$messageId = htmlspecialchars($_POST['messageId']); //gere les caracteres speciaux des messages

if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['deleteMessage'])) { //lors du clique sur le bouton active la fonction qui efface le message 
    deleteMessage($pdo, $messageId);
}


function deleteMessage($connexion, $id)
{ //efface le message de la db, grace a son id
    $delete = $connexion->prepare('DELETE FROM `message` WHERE id= :idMessage');
    $delete->execute(['idMessage' => htmlspecialchars_decode($id)]);
    $deleteOk = $delete->fetchAll();
}

header('Location: ../admin.phtml'); //une fois la fonction effectué renvoie sur la meme page
exit();
