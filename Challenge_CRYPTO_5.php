<?php
include('Game.php');

$maKey = '624325caf8e8523ee04a18f2f943bc24'; // Mets ici ta Key 
$codeChallenge = 'CRYPTO_5'; // Mets ici le code challenge
$game = new Game($maKey, $codeChallenge);

$data = $game->getDatasGame(); // Pour comprendre les données proposées par le challenge
echo '<pre>';
print_r($data);
echo '</pre>';

// ---
// Code dédié au challenge
// ---

$chiffre = $data['chiffre'];
$array = $data['listeMessages'];
$diff_min = 1;
$best_binary = null;

foreach ($array as $key => $element) {
    $frequence = get_frequence(get_xor($element, $chiffre));
    $diff =  0.75 - $frequence;
    if ($diff < $diff_min) {
        $diff_min = $diff;
        $best_binary = $element;
    }
}

$out = base_convert($best_binary, 2, 16);

// ---------------------------------------------------------------
function get_frequence($xor)
{
    $nb = 0;
    //foreach pour tester l'élément et le +1 
    for ($i = 0; $i < strlen($xor); $i++) {
        if (isset($xor[$i + 1])) {
            if ($xor[$i] == $xor[$i + 1]) {
                $nb++;
            }
        }
    }
    return $nb / strlen($xor);
}

function get_xor($text, $key)
{
    for ($i = 0; $i < strlen($text); $i++) {
        $text[$i] = intval($text[$i]) ^ intval($key[$i]);
    }
    return $text;
}
// ---------------------------------------------------------------

// Pour répondre au challenge, à décommenter une fois le challenge complété
$reponse = ['reponse' => $out];
$game->push($reponse);
