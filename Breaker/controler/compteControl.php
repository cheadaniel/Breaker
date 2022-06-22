<?php


$pseudo = $_SESSION['name'];

require_once 'model/UserPDO.php'; //fichier qui connecte a la base de donnée

$userTable = $pdo->prepare(' SELECT `name` FROM user '); // on fait la commande SQL, qui récupère les name et les email dans la Table user
$userTable->execute();
$userGet = $userTable->fetchAll();



$errorMessage = null;


function differentPseudo($word, $array)
{ // verifie si le pseudo renseigner est deja utilisé/présent dans la base de donnée
    $isPseudoDifferent = null;
    for ($i = 0; $i < count($array); $i++) {
        if ($word === $array[$i]["name"] || strtoupper($word) === strtoupper($array[$i]["name"])) { //false == le pseudo est deja présent dans la base de donné (avec des differences de maj ou non)
            $isPseudoDifferent = false; //arrete de faire tourner le if
            break;
        } else {
            $isPseudoDifferent = true;
        }
    }
    return $isPseudoDifferent;
}

function inputChecking($inputs, $array)
{ //va verifier si tout les inputs renseigné sont bon
    $tableau = [true]; //contient true par defaut

    foreach ($inputs as $key => $value) // va parcourir le tableau pour chaque key et value associé
    {
        switch ($key) { //on fait un switch sur les key présente dans $_POST

            case "username": //verifie pour la key username
                if (!differentPseudo($value, $array)) {
                    array_shift($tableau);
                    array_push($tableau, "Pseudo déjà utilisé");
                }
                break; //permet d arreter le switch
        }
    }
    return $tableau[0]; //le tableau contient que un seul élément
}

function secure_entry($str)
{
    $cleaned = trim($str); //supprime les caractères invisible en debut et fin de chaine
    $cleaned = stripslashes($cleaned); //supprime les antislash
    $cleaned = htmlspecialchars($cleaned); //caratere speciaux en entité html
    return ($cleaned);
}

function changePseudoInScoreTable($connexion, $newPseudo, $id)
{ //permet de changer le pseudo dans la db
    $changePseudoScore = $connexion->prepare(' UPDATE score SET pseudo = :pseudo WHERE id_user = :id');
    $changePseudoScore->execute(['pseudo' => htmlspecialchars_decode($newPseudo), 'id' => $id]);
    $pseudoChangedInScore = $changePseudoScore->fetchAll();
}

function changePseudoInUserTable($connexion, $newPseudo, $id)
{ //change le pseudo du score 
    $changePseudoUser = $connexion->prepare(' UPDATE user SET name = :pseudo WHERE id = :id');
    $changePseudoUser->execute(['pseudo' => htmlspecialchars_decode($newPseudo), 'id' => $id]);
    $pseudoChangedInUser = $changePseudoUser->fetchAll();
}
