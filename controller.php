<?php

// Extraction des données du fichier JSON

$json = file_get_contents('data/calendar.json');
$data = json_decode($json, 1);
$appointements = $data['appointement'];
$birthdays = $data['birthday'];

// Création des tableaux de jours et de mois

$dayfr = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
$dayus = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
$months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

// Vérification de la présence des paramètres GET

if (isset($_GET['month'])) {
    $monthchosen = array_search($_GET['month'], $months)+1;
}
else {
    $monthchosen = date("n");
}

if (isset($_GET['year'])) {
    $yearChosen = $_GET['year'];
}
else {
    $yearChosen = date("o");
}

//Création du tableau associatif des anniversaires

$birthdates = [];
foreach ($birthdays as $birthday) {
    $time = strtotime($birthday['date']);
    $month = date("n",$time);
    $day = date("j",$time);

    $birthdates[mktime (0, 0, 0, $month, $day, $yearChosen)] = [];
}

foreach ($birthdays as $birthday) {
    $time = strtotime($birthday['date']);
    $month = date("n",$time);
    $day = date("j",$time);
    if (key_exists(mktime (0, 0, 0, $month, $day, $yearChosen), $birthdates)) {
        array_push($birthdates[mktime (0, 0, 0, $month, $day, $yearChosen)], 'Anniversaire de ' . $birthday['name']);
    }
}

// Création du tableau associatif des rendez-vous

$appointementdates = [];
foreach ($appointements as $appointement) {
    $time = strtotime($appointement['time']);
    $month = date("n",$time);
    $day = date("j",$time);
    $hour = date("H",$time);
    $minutes = date("i",$time);

    $appointementdates[mktime (0, 0, 0, $month, $day, $yearChosen)] = [];
}

foreach ($appointements as $appointement) {
    $time = strtotime($appointement['time']);
    $month = date("n",$time);
    $day = date("j",$time);
    $hour = date("H",$time);
    $minutes = date("i",$time);

    if (key_exists(mktime (0, 0, 0, $month, $day, $yearChosen), $appointementdates)) {
        array_push($appointementdates[mktime (0, 0, 0, $month, $day, $yearChosen)], 'Rendez-vous '. $appointement['name'] . ' à ' . $appointement['place'] . ' à ' . $hour . 'h' . $minutes);
    }
}

// Création du tableau associatif des jours fériés

$publicholidays = [
    mktime (0, 0, 0, 1, 1, $yearChosen) => 'Jour de l\'an',
    easter_date($yearChosen)+1*86400 => 'Lundi de Pâques',
    mktime (0, 0, 0, 5, 1, $yearChosen) => 'Fête du Travail',
    mktime (0, 0, 0, 5, 8, $yearChosen) => 'Victoire 45',
    easter_date($yearChosen)+39*86400 => 'Ascension',
    easter_date($yearChosen)+50*86400 => 'Lundi de Pentecôte',
    mktime (0, 0, 0, 7, 14, $yearChosen) => 'Fête Nationale',
    mktime (0, 0, 0, 8, 15, $yearChosen) => 'Assomption',
    mktime (0, 0, 0, 11, 1, $yearChosen) => 'Toussaint',
    mktime (0, 0, 0, 11, 11, $yearChosen) => 'Armistice',
    mktime (0, 0, 0, 12, 25, $yearChosen) => 'Jour de Noël',
];

$holidates = [];
foreach ($publicholidays as $key => $publicholiday) {
    $holidates[$key] = [];
}

foreach ($publicholidays as $key => $publicholiday) {

    if (key_exists(($key), $holidates)) {
        array_push($holidates[$key], $publicholiday);
    }
}

// Timestamp du jour

$today = strtotime('today midnight');


// Création des variable de timestamp pour le premier et le dernier jour du mois

$date = 'Mois de '.$months[$monthchosen-1].' '.$yearChosen;

$nbofdaysinmonth = (new DateTime($yearChosen.'-'.$monthchosen))-> format('t');

$timestampfirst = mktime (0, 0, 0, $monthchosen, 1, $yearChosen);
$nameofthefirstday = date("l", $timestampfirst);
$numberofthefirstday = date('N', $timestampfirst);
$nameofthefirstdayfr = str_replace($dayus, $dayfr, $nameofthefirstday);

$timestamplast = mktime (0, 0, 0, $monthchosen+1, 0, $yearChosen);
$nameofthelastday = date("l", $timestamplast);
$numberofthelastday = date('N', $timestamplast);
$nameofthelastdayfr = str_replace($dayus, $dayfr, $nameofthelastday);

include ('calendar.php');
?>