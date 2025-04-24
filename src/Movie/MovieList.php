<?php

namespace App\Command\Movie;
include __DIR__ . '/../../vendor/autoload.php';


use GuzzleHttp\Client;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function App\Command\getApiKey;

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

        $apikey = getApiKey();

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
