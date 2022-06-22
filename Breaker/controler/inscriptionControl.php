<?php
require_once '../model/UserPDO.php';  //fichier qui connecte a la base de donnée
$userTable = $pdo->prepare(' SELECT `name`,`email` FROM user '); // on fait la commande SQL, qui récupère les name et les email dans la Table user
$userTable->execute();
$userGet = $userTable->fetchAll();



$errorMessage = null;

/******** EMAIL VERIFCATION ********/

function mailVerif($word): bool
{
    $mailIsValid = null;
    if (preg_match('~(\.com|\.fr|\.io)$~', $word) && filter_var($word, FILTER_VALIDATE_EMAIL)) { //accepte seulement les adresses par .com .fr .io, comme la verif de mail n'est pas faite
        $mailIsValid = true;
    } else {
        $mailIsValid = false;
    }
    return $mailIsValid;
}

function differentMail($word, $array)
{ // verifie si le mail renseigner est deja utilisé/présent dans la base de donnée
    $isEmailDifferent = null;
    for ($i = 0; $i < count($array); $i++) {
        if (password_verify($word, $array[$i]["email"])) {
            $isEmailDifferent = false; // false == le mail est deja présent dans la base de donné
            break; //arrete de faire tourner le if
        } else {
            $isEmailDifferent = true; // true == le mail n'est pas présent dans la base de donnée
        }
    }
    return $isEmailDifferent;
}

/******** PSEUDO VERIFCATION ********/

function differentPseudo($word, $array)
{ // verifie si le pseudo renseigner est deja utilisé/présent dans la base de donnée
    $isPseudoDifferent = null;
    for ($i = 0; $i < count($array); $i++) {
        if ($word === $array[$i]["name"] || strtoupper($word) === strtoupper($array[$i]["name"])) { //false == le pseudo est deja présent dans la base de donné
            $isPseudoDifferent = false; //arrete de faire tourner le if
            break;
        } else {
            $isPseudoDifferent = true;
        }
    }
    return $isPseudoDifferent;
}

/******** PASSWORD VERIFCATION ********/
function passwordLength($word)
{ // vérifie la longueur du mot de passe il faut au moins 7 caractères
    $passwordLength = false;
    if (strlen($word) >= 7) {
        $passwordLength = true;
    }

    return $passwordLength;
}


function samePassword($wordOne, $wordTwo)
{ //verifie si les mdp sont les meme lors de la verifiaction
    $isSamePassword = null;
    if ($wordOne === $wordTwo) {
        $isSamePassword = true;
    } else {
        $isSamePassword = false;
    }
    return $isSamePassword;
}

/***** VERICATION ON ALL THE INPUTS *****/

function inputChecking($inputs, $array)
{ //va verifier si tout les inputs renseigné sont bon
    $tableau = [true]; //contient true par defaut

    foreach ($inputs as $key => $value) // va parcourir le tableau pour chaque key et value associé
    {
        switch ($key) { //on fait un switch sur les key présente dans $_POST
            case "email": //verifie pour la key email
                if (!differentMail($value, $array)  || !mailVerif($value)) {
                    array_shift($tableau); //detruit la valeur true
                    array_push($tableau, "Mail déjà utilisé ou mauvais format (doit finir en : .com / .fr / .io)"); //ajoute le string
                }
                break; //permet d arreter le switch

            case "username": //verifie pour la key username
                if (!differentPseudo($value, $array)) {
                    array_shift($tableau);
                    array_push($tableau, "Pseudo déjà utilisé");
                }
                break; //permet d arreter le switch

            case "password": //verifie pour la key password
                if (!samePassword($value, $_POST["password_verif"]) || !passwordLength($value)) // on compare avec la verif du mdp
                {
                    array_shift($tableau);
                    array_push($tableau, "Mot de passe différent");
                }
                break; //permet d arreter le switch

            case "password_verif":
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

function addBDD($connexion, $word1, $word2, $word3)
{

    $query = $connexion->prepare(
        "INSERT into `user` (name, email, password)
         VALUES (:name,:email,:password)"
    );
    $query->execute(['name' => $word1, 'email' => $word2, 'password' => $word3]);
}

require_once '../connexion/inscription.phtml';
