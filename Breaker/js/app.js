import paddle from "../module/Paddle.js";
import ball from "../module/Ball.js";
import brick from "../module/Brick.js";

const cvs = document.querySelector("#breakOut");
const ctx = cvs.getContext("2d");

const score = document.querySelector("#score"); // pour écrire le score sur la page HTML
const sendScore = document.querySelector("#sendScore");

ctx.lineWidth = 3; //ligne épaisse dans le canvas

const msgArrow = document.querySelector("#msgArrow");

// console.log(client.width);
window.addEventListener("resize", function () {
  const client = {
    width: document.documentElement.clientWidth,
    height: document.documentElement.clientHeight,
  };
  if (client.width > 980)
    msgArrow.innerHTML = "(flèche gauche/flèche droite du clavier pour bouger)";
  else msgArrow.innerHTML = "(flèche gauche/flèche droite pour bouger)";
});

/*********************** GAME VARIABLES ************************/
let LIFE = 3; // 3 pv
let SCORE = 0;
let finalScore;
const SCORE_UNIT = 10;

/*********************** PADDLE ************************/
const PADDLE_WIDTH = 100; //longueur du paddle
const PADDLE_HEIGHT = 20; // hauteur du paddle
const PADDLE_MARGIN_BOTTOM = 50; //sa position bas du paddle p/r au bottom du canvas

let xPaddle = cvs.width / 2 - PADDLE_WIDTH / 2; //determine la position x : moitié du canvas - moitié de la longueur du paddle
let yPaddle = cvs.height - PADDLE_HEIGHT - PADDLE_MARGIN_BOTTOM; //determine la position y :  hauteur du canvas - hauteur du paddle - position bas du paddle
let widthPaddle = PADDLE_WIDTH;
let heightPaddle = PADDLE_HEIGHT;
let dxPaddle = 5; //le nombre de pixel dont le paddle va se deplacer quand il se deplace vers la gauche/droite
let fillColorPaddle = "#eee"; //couleur du paddle
let strokeColorPaddle = "#ffcd05"; // coueleur du contour

const Paddle = new paddle(
  xPaddle,
  yPaddle,
  widthPaddle,
  heightPaddle,
  dxPaddle,
  fillColorPaddle,
  strokeColorPaddle,
  ctx
);

/*********************** PADDLE CONTROL ************************/
let leftArrow = false;
let rightArrow = false;

const flecheGauche = document.querySelector("#fleche-gauche");
const flecheDroite = document.querySelector("#fleche-droite");

flecheGauche.addEventListener("mousedown", function () {
  leftArrow = true;
});
flecheDroite.addEventListener("mousedown", function () {
  rightArrow = true;
});
flecheGauche.addEventListener("mouseup", function () {
  leftArrow = false;
});
flecheDroite.addEventListener("mouseup", function () {
  rightArrow = false;
});
flecheGauche.addEventListener("touchstart", function () {
  leftArrow = true;
});
flecheDroite.addEventListener("touchstart", function () {
  rightArrow = true;
});
flecheGauche.addEventListener("touchend", function () {
  leftArrow = false;
});
flecheDroite.addEventListener("touchend", function () {
  rightArrow = false;
});

document.addEventListener("keydown", function (event) {
  //on appuie sur une touche
  if (event.keyCode == 37) {
    //fleche gauche
    leftArrow = true;
  } else if (event.keyCode == 39) {
    //fleche droite
    rightArrow = true;
  }
});

document.addEventListener("keyup", function (event) {
  //on relache une touche
  if (event.keyCode == 37) {
    //fleche gauche
    leftArrow = false;
  } else if (event.keyCode == 39) {
    //fleche droite
    rightArrow = false;
  }
});

/*********************** PADDLE MOVEMENT ************************/

function movePaddle() {
  if (rightArrow && Paddle.x + Paddle.width - 0.5 < cvs.width) {
    //deplace vers la droite si c'est strictement inf a la taille max du canvas
    Paddle.x += Paddle.dx;
  } else if (leftArrow && Paddle.x + 0.5 > 0) {
    //deplace vers la gauche
    Paddle.x -= Paddle.dx;
  }
}

/*********************** BALL ************************/
const BALL_RADIUS = 8; //rayon de la ball

let xBall = cvs.width / 2; //ca position au milieu du canvas = milieu du paddle
let yBall = Paddle.y - BALL_RADIUS; //position initial au dessus du paddle(-le rayon)
let radiusBall = BALL_RADIUS;
let speedBall = 3;
let dxBall = 3 * (Math.random() * 2 - 1); // la ball au départ se déplacera de façon aléatoire: pour ne commencer de la meme maniere a chaque fois => met une part d'aléatoire => compris entre -3 et 3
let dyBall = -3;
let fillColorBall = "#ff7c00"; //couleur de la ball
let strokeColorBall = "blue"; // coueleur du bord

const Ball = new ball(
  xBall,
  yBall,
  radiusBall,
  speedBall,
  dxBall,
  dyBall,
  fillColorBall,
  strokeColorBall,
  ctx
);

/*********************** BALL AND WALL COLLISION DETECTION ************************/
function ballWallCollision() {
  if (Ball.x + Ball.radius > cvs.width || Ball.x - Ball.radius < 0) {
    //regarde où la ball rentre en collision : sur l'axe des x
    Ball.dx = -Ball.dx; //on retire dx a la ball pour qu'elle change de direction
    WALL_HIT.play(); // Active le son lors de la collision Ball/Wall
  }

  if (Ball.y - Ball.radius < 0) {
    // regarde si collision : sur l'axe y est au top du canvas = y=0
    Ball.dy = -Ball.dy; //on retire dy a la ball pour qu'elle change de direction
    WALL_HIT.play(); // Active le son lors de la collision Ball/Wall
  }

  if (Ball.y + Ball.radius > cvs.height) {
    // regarde si collision : sur l'axe y est au bot du canvas = y=taille du canvas
    LIFE--; // si la ball touche le bottom du canvas on perd une vie
    LIFE_LOST.play();
    resetBall(); // fait un reset la ball a sa position initiale
  }
}

/*********************** BALL RESET ************************/
function resetBall() {
  Ball.x = cvs.width / 2;
  Ball.y = Paddle.y - BALL_RADIUS;
  Ball.dx = 3 * (Math.random() * 2 - 1);
  Ball.dy = -3;
}

/*********************** BALL AND PADDLE COLLISION DETECTION ************************/

function ballPaddleCollision() {
  //delimite les bord du paddle et les rends hérmétique p/r a la Ball
  if (
    Ball.x < Paddle.x + Paddle.width && // regarde si la collision se fait entre la droite du paddle et la gauche de la balle
    Ball.x > Paddle.x && // regarde si la collision se fait entre la gauche du paddle et la droite de la balle
    Paddle.y < Paddle.y + Paddle.height && //regarde si la collision se fait entre le haut de la Ball et bas du Paddle
    Ball.y > Paddle.y
  ) {
    // regarde si la collision se fait entre le bas de la Ball et haut du Paddle
    // PLAY SOUND
    PADDLE_HIT.play(); // Active le son lors de la collision Ball/Paddle

    // CHECK WHERE THE BALL HIT THE PADDLE
    let collidePoint = Ball.x - (Paddle.x + Paddle.width / 2);

    // NORMALIZE THE VALUES
    collidePoint = collidePoint / (Paddle.width / 2);

    // CALCULATE THE ANGLE OF THE BALL
    let angle = (collidePoint * Math.PI) / 3;

    Ball.dx = Ball.speed * Math.sin(angle);
    Ball.dy = -Ball.speed * Math.cos(angle);
  }
}

/*********************** BRICKS ************************/
let rowBrick = 1; // nombre de ligne
let columnBrick = 7; // nombre de colonne
let widthBrick = 40; // longueur de la brique
let heightBrick = 20; // hauteur de la brique
let offSetLeftBrick = 15; // distance a gauche de la brique
let offSetTopBrick = 15; // distance en haut de la brique
let topMarginBrick = 40; // distance entre le top du canvas et la première ligne de brick
let fillColorBrick = "blue"; // couleur de la brique
let strokeColorBrick = "#ff7c00"; // couleur du contour de la brique

let Brick = new brick(
  rowBrick,
  columnBrick,
  widthBrick,
  heightBrick,
  offSetLeftBrick,
  offSetTopBrick,
  topMarginBrick,
  fillColorBrick,
  strokeColorBrick
);

let bricks = []; //liste qui va comprendre l'objet brique créé plus bas

function createBricks() {
  for (let r = 0; r < Brick.row; r++) {
    // nombre de ligne qu'on veux
    bricks[r] = [];
    for (let c = 0; c < Brick.column; c++) {
      // nombre de colonne qu'on veux
      bricks[r][c] = {
        x: c * (Brick.offSetLeft + Brick.width) + Brick.offSetLeft, //en partant de la gauche : 0*(15+45)+15 = 15 (la premiere colonne de brique se situe a 15 pixel du bord gauche)
        // 1*(15+45)+15=75 (la deuxieme colonne brique se situe a 75 pixel du bord gauche) etc

        y:
          r * (Brick.offSetTop + Brick.height) +
          Brick.offSetTop +
          Brick.topMargin, //en partant du top : 0*(15+20)+15+40 = 55 (la premiere ligne se situe a 55 pixel du top)
        // 1*(15+20)+15+40 = 90 (la deuxieme ligne situe a 90 pixel du top) etc

        status: true, // savoir si la brique est cassé ou non (true = non cassé)
      };
    }
  }
}

createBricks();

function drawBricks() {
  for (let r = 0; r < Brick.row; r++) {
    for (let c = 0; c < Brick.column; c++) {
      let b = bricks[r][c];
      // si la brique est non cassé
      if (b.status) {
        // == true on affiche la brique
        ctx.fillStyle = Brick.fillColor;
        ctx.fillRect(b.x, b.y, Brick.width, Brick.height);

        ctx.strokeStyle = Brick.strokeColor;
        ctx.strokeRect(b.x, b.y, Brick.width, Brick.height);
      }
    }
  }
}

/*********************** BALL AND BRICK COLLISION DETECTION ************************/

function ballBrickCollision() {
  for (let r = 0; r < Brick.row; r++) {
    for (let c = 0; c < Brick.column; c++) {
      let b = bricks[r][c];

      if (b.status) {
        // si la brique est non cassé
        if (
          Ball.x + Ball.radius >
            b.x /* si la droite de la ball touche la gauche de la brique */ &&
          Ball.x - Ball.radius <
            b.x +
              Brick.width /* si la gauche de la ball touche la doite de la brique */ &&
          Ball.y + Ball.radius >
            b.y /* si le bas de la ball touche le haut de la brique */ &&
          Ball.y - Ball.radius <
            b.y +
              Brick.height /* si le haut de la ball touche le bas de la brique */
        ) {
          BRICK_HIT.play(); // Active le son lors de la collision Ball/Brick
          Ball.dy = -Ball.dy; // change la direction de la ball (on l'inverse)
          b.status = false; // brique est cassé et ne s'affichera plus
          SCORE += SCORE_UNIT; // augmente le score par SCORE_UNIT
        }
      }
    }
  }
}

/*********************** GAME STATISTIQUE ************************/
function showGameStats(text, textX, textY, img, imgX, imgY) {
  // draw text
  ctx.fillStyle = "#FFF";
  ctx.font = "25px Germania One";
  ctx.fillText(text, textX, textY);

  // draw image
  ctx.drawImage(img, imgX, imgY, 25, 25);
}

/*********************** GAME OVER ************************/
let GAME_OVER = false;
function gameOver() {
  if (LIFE <= 0) {
    showYouLose();
    GAME_OVER = true;
  }
}
/*********************** SHOW YOU LOOSE/WIN ************************/
function showYouLose() {
  gameover.style.display = "block";
  youlose.style.display = "block";
  finalScore = score.innerHTML;
  sendScore.style.display = "block";
}

function showYouWin() {
  gameover.style.display = "block";
  youwon.style.display = "block";
  sendScore.style.display = "block";
}

/*********************** LEVEL UP ************************/
let LEVEL = 1;
const MAX_LEVEL = 10;

function levelUp() {
  let isLevelDone = true; //valeur par defaut

  // verifie si toutes les brick sont cassés
  for (let r = 0; r < Brick.row; r++) {
    // on va regarder chaque brique
    for (let c = 0; c < Brick.column; c++) {
      isLevelDone = isLevelDone && !bricks[r][c].status; //verifie si la brique est cassé => Si cassé renvoie false et donc ! false = true et true*true =>true, si non cassé renvoie true et donc ! true = false et true*false => false
    }
  }

  if (isLevelDone) {
    //si level terminé => on recré un nv level
    WIN.play();

    if (LEVEL >= MAX_LEVEL) {
      // s'arrete au moment ou on atteint le dernier lvl
      showYouWin();
      GAME_OVER = true;
      return; //permet de ne pas faire le reste de la fonction si le joueur finit le max de lvl
    }

    Brick.row++; // augmente le nombre de ligne
    createBricks(); // redéssine les brique
    Ball.speed += 0.5; // augmente la vitesse de la ball par 0.5
    LEVEL++; //on augmente le lvl de 1
    resetBall(); //remet la ball a sa position initial
  }
}

function draw() {
  Paddle.drawPaddle();
  Ball.drawBall();
  drawBricks();

  showGameStats(SCORE, 35, 25, SCORE_IMG, 5, 5); // Affiche le score
  showGameStats(LIFE, cvs.width - 25, 25, LIFE_IMG, cvs.width - 55, 5); // Affiche le pv
  showGameStats(LEVEL, cvs.width / 2, 25, LEVEL_IMG, cvs.width / 2 - 30, 5); // Affiche le lvl actuel
}

function update() {
  movePaddle();
  Ball.moveBall();
  ballWallCollision();
  ballPaddleCollision();
  ballBrickCollision();
  gameOver();
  levelUp();

  score.innerHTML = SCORE; // affiche le score et l'actualise
}

function loop() {
  //clear the canvas
  ctx.drawImage(BG_IMG, 0, 0); //met un bgc
  draw();
  update();

  if (!GAME_OVER) {
    // si GAME_OVER = true alors on stop la demande d'animation
    requestAnimationFrame(loop);
  }
}
const started = document.querySelector("#started");
const launch = document.querySelector("#launch");
started.addEventListener("click", function () {
  launch.style.display = "none";
  loop();
});

/*************************** SHOW GAME OVER MESSAGE **************/
/* SELECT ELEMENTS */
const gameover = document.querySelector("#gameover");
const youwon = document.querySelector("#youwin");
const youlose = document.querySelector("#youlose");
const restart = document.querySelector("#restart");

// PLAY AGAIN
restart.addEventListener("click", function () {
  location.reload(); // reload the page
});
let pseudo = document.querySelector("#pseudoPlayer"); // recupère le pseudo du joueur sur la page directement
pseudo = pseudo.innerHTML;

export { finalScore, pseudo }; // exporte les variables dont on a besoin pour l'enregistrer dans la BDD
