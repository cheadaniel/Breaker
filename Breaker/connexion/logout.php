<?php

session_start(); // pour continuer la session deja en cours
unset($_SESSION['connecte']); // pour detruire la variable quil lui etait associé
header('Location: ../homePage.phtml'); //redirige apres la deco vers la page de connexion