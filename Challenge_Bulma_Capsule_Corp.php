<?php
include('Game.php');

$maKey = '624325caf8e8523ee04a18f2f943bc24'; // Mets ici ta Key 
$codeChallenge = 'DBZ_2'; // Mets ici le code challenge
$game = new Game($maKey, $codeChallenge);

$data = $game->getDatasGame(); // Pour comprendre les données proposées par le challenge
echo '<pre>';
print_r($data);
echo '</pre>';

// ---
// Code dédié au challenge
// ---



//Fonction ecodage des objets au format du nom des capsule
function encodeObjet($object)
{
    $objectsParts = explode('-', $object);

    $smallName = substr($objectsParts[0], 0, 2) . substr($objectsParts[0], -2);
    $roundedWeight = floor($objectsParts[1] / 10); 

    return $smallName . '-' . $roundedWeight;
}

//Fonction qui récupère le poid de l'objet
function getWeight($object)
{
    return explode('-', $object)[1];
}


//----MAIN----
$objects = $data['objets'];
$capsules = $data['capsules'];
$totalWeight = 0;

foreach ($objects as $object) {

    $encodedObject = encodeObjet($object);

    foreach ($capsules as $capsule) {

        if ($encodedObject == $capsule) {
            print($encodedObject . ' = ' . $capsule . '</br>');
            $totalWeight += getWeight($object);
        }
    }
}

print($totalWeight);

// Pour répondre au challenge, à décommenter une fois le challenge complété
$reponse = ['reponse' => $totalWeight];
$game->push($reponse);
