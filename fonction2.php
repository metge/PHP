<?php
declare(strict_types=1);

/**
 * Détermine si une date donnée correspond à un jour travaillé en France
 * 
 * @param string $date Format attendu : YYYY-MM-DD (ex: 2009-06-09)
 * @return bool true si jour travaillé, false sinon
 * @throws InvalidArgumentException Si le format de date est invalide
 * @author christophe@metge.eu
 * @since 2014-12-01
 */
function isWorkingDay(string $date): bool 
{
    // Validation du format de la date
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        throw new InvalidArgumentException('Format de date invalide. Format attendu : YYYY-MM-DD');
    }

    // Conversion de la date
    $dateComponents = explode('-', $date);
    $year = (int)$dateComponents[0];
    $month = (int)$dateComponents[1];
    $day = (int)$dateComponents[2];
    
    // Vérification de la validité de la date
    if (!checkdate($month, $day, $year)) {
        throw new InvalidArgumentException('Date invalide');
    }

    $dateTimestamp = mktime(0, 0, 0, $month, $day, $year);
    
    // Calcul des jours fériés basés sur Pâques
    $easterTimestamp = easter_date($year);
    $easterMonday = date('Y-m-d', strtotime('+1 day', $easterTimestamp));
    $ascensionDay = date('Y-m-d', strtotime('+39 days', $easterTimestamp));
    $whitMonday = date('Y-m-d', strtotime('+50 days', $easterTimestamp));

    // Liste des jours fériés fixes et variables
    $holidays = [
        "$year-01-01", // Jour de l'an
        "$year-05-01", // Fête du travail
        "$year-05-08", // Victoire 1945
        "$year-07-14", // Fête nationale
        "$year-08-15", // Assomption
        "$year-11-01", // Toussaint
        "$year-11-11", // Armistice
        "$year-12-25", // Noël
        $easterMonday,
        $ascensionDay,
        $whitMonday
    ];

    // Vérification weekend (6: samedi, 7: dimanche) ou jour férié
    $dayOfWeek = (int)date('N', $dateTimestamp);
    
    return !($dayOfWeek >= 6 || in_array($date, $holidays, true));
}


try {
    $isWorking = isWorkingDay('2024-02-02');
    echo $isWorking ? 'Jour travaillé' : 'Jour non travaillé';
} catch (InvalidArgumentException $e) {
    echo "Erreur : " . $e->getMessage();
}
