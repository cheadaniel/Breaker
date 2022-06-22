<?php

require_once '../model/UserPDO.php';
function addBDDScore($connexion, $word1, $word2,$word3) //fct qui ecrira le score dans la db
    {
        $query = $connexion->prepare(
            "INSERT into `score` (number, pseudo,id_user)
             VALUES (:number,:pseudo,:id_user)"
        );
        $query->execute(['number' => $word1, 'pseudo' => $word2, 'id_user' => $word3]);
    };
$result = []; // on va faire un tableau d'objet qui stock le pseudo et le score du joueur

if (isset($_GET['score'])) {
    $result['score'] = $_GET["score"];
    $result['pseudo'] = $_GET["pseudo"];
    
    $getIdFromBDD = $pdo->prepare(' SELECT `id`  FROM `user` WHERE `name` =  :pseudo '); //recupere l'id du joueur
    $getIdFromBDD ->execute(['pseudo' => $result["pseudo"]]);
    $idGet = $getIdFromBDD -> fetchAll();
    // var_dump($idGet);
    $idPlayer = $idGet[0]['id'];
    
    $getScoreTable= $pdo->prepare(' SELECT `number` FROM score  WHERE `pseudo` =  :pseudo ORDER BY number DESC'); //recupere tous les score du joueur pour les comparer avec le score qui va entrer
    $getScoreTable->execute(['pseudo' => $result["pseudo"]]);
    $scoreGet = $getScoreTable->fetchAll();
    // var_dump($scoreGet);
    
    
    $arrayOfScore = []; // contiendra un tableau des valeurs des scores du joueur
    for ($i = 0; $i < count($scoreGet) ; $i ++)
    {
        array_push($arrayOfScore,$scoreGet[$i]['number']);
    }
        // var_dump($arrayOfScore);
    
    if (count($scoreGet) == 0) addBDDScore($pdo,$result["score"],$result["pseudo"],$idPlayer); //pour les nvx joueurs d'enregistrer un premier score
    
    
    for ($i =0; $i < count($arrayOfScore); $i ++) { //eviter les scores en double et enregistrer les nvx scores
        if (in_array($result['score'],$arrayOfScore)) break;
        else {
            addBDDScore($pdo,$result["score"],$result["pseudo"],$idPlayer); 
            break; 
            
        }
    }
    

}   
echo json_encode($result); // permet de voir ce qui est recuperer dans le json
