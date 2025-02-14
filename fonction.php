<?php
/*
@author christophe@metge.eu
@since 2014-12-01
@comment
    function Jour Travailé ()
    Input : date au format 2009-06-09
    Output : retourne 1 si le jour est travaillé, sinon 0
*/
function JourDeTravail($date_yyyy_mm_jj) {
    // $date_yyyy_mm_jj au format 2009-06-09
    // retourne 1 si le jour est travaillé, sinon 0
    $tab = explode("-",$date_yyyy_mm_jj);
    $annee = $tab['0'];
    $date_timestamp = mktime(0,0,0,$tab['1'],$tab['2'],$annee);
 
    $PaquesDim = easter_date($annee);
    $PaquesLun      = date('Y-m-d', mktime(0,0,0, date("m",$PaquesDim), date("d",$PaquesDim)+01, date("Y",$PaquesDim)));
    $AscensionJeu   = date('Y-m-d', mktime(0,0,0, date("m",$PaquesDim), date("d",$PaquesDim)+39, date("Y",$PaquesDim)));
    $PentecoteLun   = date('Y-m-d', mktime(0,0,0, date("m",$PaquesDim), date("d",$PaquesDim)+50, date("Y",$PaquesDim)));

    $Tab_JoursFeries = array(
    "$annee-01-01",
    "$annee-05-01",
    "$annee-05-08",
    "$annee-07-14",
    "$annee-08-15",
    "$annee-11-01",
    "$annee-11-11",
    "$annee-12-25",
    $PaquesLun,
    $AscensionJeu,
    $PentecoteLun,
    );
 
    $JourDeLaSemaine = date('N', $date_timestamp); // 6 : samedi / 7 : dimanche
    if($JourDeLaSemaine == 6 || $JourDeLaSemaine == 7 || in_array($date_yyyy_mm_jj,$Tab_JoursFeries)) {
        $Travail = 0;
    }
    else {
        $Travail = 1;
    }
    return $Travail;
}
