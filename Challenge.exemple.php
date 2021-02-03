<?php
include('Game.php');

$maKey = '624325caf8e8523ee04a18f2f943bc24'; // Mets ici ta Key 
$codeChallenge = ''; // Mets ici le code challenge
$game = new Game($maKey, $codeChallenge);

$data = $game->getDatasGame(); // Pour comprendre les données proposées par le challenge
echo '<pre>';
print_r($data);
echo '</pre>';	

// ---
// Code dédié au challenge
// ---

// Pour répondre au challenge, à décommenter une fois le challenge complété
// $reponse = ['reponse' => ...];
// $game->push($reponse);
