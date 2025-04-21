<?php

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
#[AsCommand(name: 'app:helloworld')]
class HelloworldCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://www.omdbapi.com',
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);

        $response = $client->request('GET', 'https://www.omdbapi.com',[
            'query' => [
                'apikey' => '63a9c267',
                'i' => 'tt1285016'
            ]
        ]);
        
        var_dump($response);
        return Command::SUCCESS;
    }
}

$application = new Application();
$application->add( new HelloworldCommand());
$application->run();