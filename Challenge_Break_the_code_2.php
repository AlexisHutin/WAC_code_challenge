<?php
include('Game.php');

$maKey = '624325caf8e8523ee04a18f2f943bc24'; // Mets ici ta Key 
$codeChallenge = 'CRYPTO_3'; // Mets ici le code challenge
$game = new Game($maKey, $codeChallenge);

$data = $game->getDatasGame(); // Pour comprendre les données proposées par le challenge
echo '<pre>';
print_r($data);
echo '</pre>';

// ---
// Code dédié au challenge
// ---

//--- Split de la string de base en morceaux de différentes tailles ---/
function splitString($baseString, $eachLetters, $lenght)
{
    $stringsToTest = [];
    foreach ($eachLetters as $index => $letter) {
        if (strlen(substr($baseString, $index, $lenght)) == $lenght) {
            $stringsToTest[] = substr($baseString, $index, $lenght);
        }
    }
    return $stringsToTest;
}


//--- test de chaque morceaux ---//
function testString($stringToTest, $baseString)
{
    if (substr_count($baseString, $stringToTest) >= 4) {
        return $stringToTest;
    } else {
        return false;
    }
}

//--- MAIN ---//

$baseString = $data['letters'];
$eachLetters = str_split($data['letters'], 1);
$stringMaxLength = round(strlen($baseString) / 4);

for ($i = 8; $i <= $stringMaxLength; $i++) {
    $stringsToTest = splitString($baseString, $eachLetters, $i);
    foreach ($stringsToTest as $string) {

        if (testString($string, $baseString)) {
            $code = testString($string, $baseString);
        }
    }
}

echo '<pre>';
print($code);
echo '</pre>';

// Pour répondre au challenge, à décommenter une fois le challenge complété
$reponse = ['reponse' => $code];
$game->push($reponse);
