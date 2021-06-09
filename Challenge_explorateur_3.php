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
    // Je sépare en deux parties chaque éléments du tableau
    $code_population = explode(':', $population)[0];
    $extrait_du_langage = explode(':', $population)[1];

    // Je fais appel à une fonction qui fait toute les vérifications
    // Si l'extrait passe tout les tests j'ajoute le code de la population à ma chaîne de caractères
    if (processAllChecks($extrait_du_langage)) {
        $populations_dechiffrable .= $code_population;
    }
}

// Si aucune des population n'a de langage déchiffrable
if ($populations_dechiffrable == '') {
    $populations_dechiffrable == 'NOPOPULATION';
}

/**
 * Cette fonction procède à une batterie de test sur l'extrait de langage
 * Si tout les tests sont réussi elle retourne true, false sinon
 * @param string $extrait_du_langage
 * @return boolean
 */
function processAllChecks(string $extrait_du_langage): bool
{
    $flag = false;

    // Certains test on besoin d'un tableau qui liste tout les mots de l'extrait
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

/**
 * Cette fonction compte le nombre de caractères unique dans l'extrait
 * Si il y en a 20 ou plus est retourne true, false sinon  
 * @param string $extrait_du_langage
 * @return boolean
 */
function checkNumberOfUniqueChar(string $extrait_du_langage): bool
{
    // Pour la suite on a besoins de supprimer tout les espaces
    $extrait_sans_espaces = str_replace(' ', '', $extrait_du_langage);

    // Cette ligne fais 3 choses :
        // - On transforme la chaîne de caractères en tableau
        // - On transforme ce tableau en tableau associatif ['élement1' => 2, 'élement2' => 1, ...]
        //   qui compte le nombre d'élément identiques dans un tableau
        // - On compte les éléments du tableau associciatif
    // On à donc le nombre de caractères unique
    $uniqueChars = count(array_count_values(str_split($extrait_sans_espaces)));

    if ($uniqueChars >= 20) {
        return true;
    }
    return false;
}

/**
 * Cette fonction compte le nombre de mots de plus de 2 caractères qui se répètent plus de 2 fois
 * Si il y en a 5 ou plus est retourne true, false sinon
 * @param array $wordsList
 * @return boolean
 */
function checkMinimumNumberOfWord(array $wordsList): bool
{
    $goodWordCount = 0;

    // Cette fonction compte le nombre d'élément identiques dans un tableau
    // Elle rend un tableau associatif ['élement1' => 2, 'élement2' => 1, ...]
    $tempArray = array_count_values($wordsList);

    foreach ($tempArray as $word => $numberOfRepeat) {
        // Pour chaque item on vérifie deux choses : 
            // - Fait-il + de 2 caractères ?
            // ET 
            // - Est-ce qu'il se répète + de 2 fois ?
        if (strlen($word) > 2 && $numberOfRepeat > 2) {
            // Si c'est le cas on incrémente le compteur de mots valide.
            $goodWordCount++;
        }
    }

    if ($goodWordCount >= 5) {
        return true;
    }

    return false;
}

/**
 * Cette fonction compte le nombre de mots de de 2 caractères
 * Si il y en a 10 ou moins est retourne true, false sinon
 * @param array $wordsList
 * @return boolean
 */
function checkMaximumNumberOfWord(array $wordsList): bool
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
