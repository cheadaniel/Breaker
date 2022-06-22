<?php

require_once 'model/UserPDO.php'; //fichier qui connecte a la base de donnée

$userTable = $pdo->prepare(' SELECT `name`,`password`,`admin` FROM user '); // on fait la commande SQL, qui récupère les name et les password dans la Table user
$userTable->execute();
$userGet = $userTable->fetchAll();


$erreur = null;



if (!empty($_POST['name']) && !empty($_POST['password'])) {
    for ($i = 0; $i < count($userGet); $i++) {
        if ($_POST['name'] === htmlspecialchars_decode($userGet[$i]['name']) && password_verify(htmlspecialchars($_POST['password']), $userGet[$i]['password'])) { //verifie pour les pseudo de la base de donné 

            session_start(); //on connecte l'user si les données sont bonnes
            $_SESSION['connecte'] = 1;
            $_SESSION['name'] = $_POST['name']; // permet de recupérer le nom de l'utilisateur
            $_SESSION['admin'] = $userGet[$i]['admin'];
        } else {
            $erreur = "Identifiant incorrect";
        }
    }
}
require_once 'connexion/login.phtml';
