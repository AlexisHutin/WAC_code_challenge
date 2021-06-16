<?php
include('Game.php');

$maKey = '624325caf8e8523ee04a18f2f943bc24'; // Mets ici ta Key 
$codeChallenge = 'TENNIS_1'; // Mets ici le code challenge
$game = new Game($maKey, $codeChallenge);

$data = $game->getDatasGame(); // Pour comprendre les données proposées par le challenge
// echo '<pre>';
// print_r($data);
// echo '</pre>';


//-----------------------------------------------------------
function convertNumToPoints($points)
{
    switch ($points) {
        case 1:
            return 15;
            break;
        case 2:
            return 30;
            break;
        case 3:
            return 40;
            break;
        default:
            return 0;
            break;
    }
}
//-----------------------------------------------------------

$partie = str_split($data['points']);

$point_D = 0;
$point_N = 0;
$jeux_D = 0;
$jeux_N = 0;


foreach ($partie as $point) {

    if ($point === 'N') {
        $point_N++;
        echo 'Le joueur N marque : '. convertNumToPoints($point_N) . ':' . convertNumToPoints($point_D) .'<br>';
    } else {
        $point_D++;
        echo 'Le joueur D marque : '. convertNumToPoints($point_N) . ':' . convertNumToPoints($point_D) .'<br>';
    }

    if ($point_N == 4) {
        $jeux_N++;
        $point_N = 0;
        $point_D = 0;
        echo 'Le joueur N gagne le jeu : ' . $jeux_N . ':' . $jeux_D . ' <br>';
    }

    if ($point_D == 4) {
        $jeux_D++;
        $point_D = 0;
        $point_N = 0;
        echo 'Le joueur D gagne le jeu : ' . $jeux_N . ':' . $jeux_D . ' <br>';
    }

    if ($jeux_N == 6) {
        $jeux_N = 0;
        $jeux_D = 0;
        $point_D = 0;
        $point_N = 0;
        echo 'SET pour le joueur N ! <br>';
    }

    if ($jeux_D == 6) {
        $jeux_N = 0;
        $jeux_D = 0;
        $point_D = 0;
        $point_N = 0;
        echo 'SET pour le joueur D ! <br>';
    }
}

$reponse = $jeux_D . ':' . $jeux_N . ':' . convertNumToPoints($point_D) . ':' . convertNumToPoints($point_N);

echo 'Score : ' . $reponse;

// ---
// Code dédié au challenge
// ---

// Pour répondre au challenge, à décommenter une fois le challenge complété
$reponse = ['reponse' => $reponse];
$game->push($reponse);
