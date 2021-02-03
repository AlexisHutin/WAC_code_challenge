<?php
include('Game.php');

$maKey = '624325caf8e8523ee04a18f2f943bc24'; // Mets ici ta Key 
$codeChallenge = 'AVENGERS_1'; // Mets ici le code challenge
$game = new Game($maKey, $codeChallenge);

$data = $game->getDatasGame(); // Pour comprendre les données proposées par le challenge
echo '<pre>';
print_r($data);
echo '</pre>';

// ---
// Code dédié au challenge
// ---

$thanos = $data['thanos'];
$compteur = 0;
$bonus_iron_man = 0;
$bonus_spiderman = 0;
$bonus_captain_america = 0;
$bonus_thor = 0;

do {

    switch (($compteur - 1) % 4) {
        case 0:

            print('Ironman +1 <br>');
            $bonus_iron_man++;

            break;
        case 1:

            print('Spiderman +1 <br>');
            $bonus_spiderman++;

            break;
        case 2:

            print('Captain America +1 <br>');
            $bonus_captain_america++;

            break;
        case 3:

            print('Thor +1 <br>');
            $bonus_thor++;

            break;
    }

    $iron_man = (($data['iron_man'] + $bonus_iron_man) * 3) + 10;
    print('Ironman : ' . $iron_man . '<br>');

    $spiderman = (($data['spiderman'] + $bonus_spiderman) * 4) + 5;
    print('Spiderman : ' . $spiderman . '<br>');

    $captain_america = (($data['captain_america'] + $bonus_captain_america) * 3) + 7;
    print('Captain America : ' . $captain_america . '<br>');

    $thor = (($data['thor'] + $bonus_thor) * 4) + 20;
    print('Thor : ' . $thor . '<br>');

    $avengers = $iron_man + $spiderman + $captain_america + $thor;
    print('Avengers : ' . $avengers . '<br>');
    print('Thanos : ' . $thanos . '<br>');

    $compteur++;
    print('Compteur : ' . $compteur . '<br>');

    print('<hr>');
} while ($avengers < $thanos);

print('Compteur : ' . $compteur . '<br>');


// Pour répondre au challenge, à décommenter une fois le challenge complété
$reponse = ['reponse' => $compteur];
$game->push($reponse);
