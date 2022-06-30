<!doctype html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="./style.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="./img/the_breaker_logo.png" />
    <title>The Breaker</title>
    <meta name="description" content="The Breaker est un casse-brique. C'est le premier projet sur lequel je travaille en autonomie. Il reprend le principe de base du jeu. On peut y enregistrer son score (si on le souhaite) et le comparer aux autres joueurs. On peut aussi discuter avec ces mêmes autres joueurs sur page de chat dédiée.">
    <link href="https://fonts.googleapis.com/css2?family=Courgette&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>-->
</head>

<body>
    <header class="header">
        <div class="logo">
            <a href="./index.php">
                <img src="img/the_breaker_logo.png" alt="logo">
            </a>
        </div>

        <nav>
            <ul class="navbar">
                <li>
                    <a href="./index.php">
                        Breaker
                    </a>
                </li>
                <li>
                    <a href="./contact.phtml">
                        Contact
                    </a>
                </li>
                <?php if (is_connect()) : // s affiche seuelement si le joueur est connecté
                ?>
                <li>
                    <a href="./chatRoom.phtml">
                        ChatRoom
                    </a>
                </li>
                <li>
                    <a href="./compte.phtml">
                        Compte
                    </a>
                </li>

                    <?php if ($_SESSION['admin'] == true) : // s'affiche seulement si le joueur est admin
                    ?>
                        <li>
                            <a href="./admin.phtml">
                                Admin
                            </a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a href="connexion/logout.php">
                            Logout
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>