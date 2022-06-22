<?php

function is_connect(): bool
{ //savoir si l'user est connecté
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); //demarre la session si elle n'a pas débuté
    }
    return !empty($_SESSION['connecte']); //session = non modifiable par l'user // connecte prends une valeur si l'utilisateur est
}

function user_must_connect(): void
{ //forcé l'utilisateur a ce connecté
    if (!is_connect()) {
        header('Location: ./controler/loginControl.php'); //location renvoie sur la page indiqué
        exit(); //ne souhaite pas executé le reste du script
    }
}
