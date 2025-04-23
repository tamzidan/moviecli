<?php

// https://www.omdbapi.com/?apikey=63a9c267&s=Batman

// src/Command/CreateUserCommand.php
namespace App\Command;
use GuzzleHttp\Client;


include 'vendor/autoload.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'movie:detail')]
class MovieDetail extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://www.omdbapi.com',
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);

        $apikey = trim(file_get_contents(__DIR__ . '/../apikey.txt'));

        $response = $client->request('GET', 'https://www.omdbapi.com',[
            'query' => [
                'apikey' => $apikey,
                // TODO:Jadiin i diambil dari parameter cli
                'i' => 'tt1285016'
            ]
        ]);
        
        $bodyString = (string)$response->getBody();
        $bodyObject = json_decode($bodyString);
        var_dump($bodyObject->Title);
        return Command::SUCCESS;
    }
}



#[AsCommand(name: 'movie:list')]
class MovieList extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://www.omdbapi.com',
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);

        $apikey = trim(file_get_contents(__DIR__ . '/../apikey.txt'));

        $response = $client->request('GET', 'https://www.omdbapi.com',[
            'query' => [
                'apikey' => $apikey,
                // TODO:Jadiin i diambil dari parameter cli
                's' => 'batman'
            ]
        ]);

        $bodyString = (string)$response->getBody();
        $bodyObject = json_decode($bodyString);
        $result = $bodyObject->Search;

        foreach ($result as $key => $value) {
            echo $value->Title . PHP_EOL;
        }        
        
        return Command::SUCCESS;
    }
}

$application = new Application();
$application->add( new MovieList());
$application->add( new MovieDetail());

$application->run();