<?php
include('Game.php');

$maKey = '624325caf8e8523ee04a18f2f943bc24'; // Mets ici ta Key 
$codeChallenge = 'EXPLORER_3'; // Mets ici le code challenge
$game = new Game($maKey, $codeChallenge);

$data = $game->getDatasGame(); // Pour comprendre les données proposées par le challenge
echo '<pre>';
print_r($data);
echo '</pre>';

// ---
// Code dédié au challenge
// ---

$populations = $data['populations'];

$populations_dechiffrable = '';

foreach ($populations as $population) {
    $code_population = explode(':', $population)[0];
    $extrait_du_langage = explode(':', $population)[1];

    if (processAllChecks($extrait_du_langage)) {
        $populations_dechiffrable .= $code_population;
    }
}

if ($populations_dechiffrable == '') {
    $populations_dechiffrable == 'NOPOPULATION';
}

print($populations_dechiffrable);

function processAllChecks($extrait_du_langage)
{
    $flag = false;

    $wordsList = explode(' ', $extrait_du_langage);

    if (
        checkNumberOfUniqueChar($extrait_du_langage) &&
        checkMinimumNumberOfWord($wordsList) &&
        checkMaximumNumberOfWord($wordsList)
    ) {
        $flag = true;
    }

    return $flag;
}

function checkNumberOfUniqueChar($extrait_du_langage)
{
    $extrait_sans_espaces = str_replace(' ', '', $extrait_du_langage);
    $uniqueChars = count(array_count_values(str_split($extrait_sans_espaces)));

    if ($uniqueChars >= 20) {
        return true;
    }
    return false;
}

function checkMinimumNumberOfWord($wordsList)
{
    $goodWordCount = 0;

    $tempArray = array_count_values($wordsList);

    foreach ($tempArray as $word => $numberOfRepeat) {
        if (strlen($word) > 2 && $numberOfRepeat > 2) {
            print($word . '->' . $numberOfRepeat . '<br>');
            $goodWordCount++;
        }
    }

    if ($goodWordCount >= 5) {
        return true;
    }

    return false;
}

function checkMaximumNumberOfWord($wordsList)
{
    $WordOfTwoLettersCount = 0;
    foreach ($wordsList as $word) {
        if (strlen($word) == 2) {
            $WordOfTwoLettersCount++;
        }
    }

    if ($WordOfTwoLettersCount <= 10) {
        return true;
    }

    return false;
}



// Pour répondre au challenge, à décommenter une fois le challenge complété
$reponse = ['reponse' => $populations_dechiffrable];
$game->push($reponse);
