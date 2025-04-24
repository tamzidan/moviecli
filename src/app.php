<?php

namespace App\Command;

include __DIR__ . '/../vendor/autoload.php';


use Movie\MovieDetail;
use Movie\MovieList;
use Symfony\Component\Console\Application;


function getApiKey() : string {
    $apikey = trim(file_get_contents(__DIR__ . '/../apikey.txt')); 
    return $apikey;
}




$application = new Application();
$application->add( new MovieList());
$application->add( new MovieDetail());

$application->run();