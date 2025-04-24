<?php

// the name of the command is what users type after "php bin/console"
namespace App\Command\Movie;
include __DIR__ . '/../../vendor/autoload.php';

use GuzzleHttp\Client;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use function App\Command\getApiKey;

#[AsCommand(name: 'movie:detail')]
class MovieDetail extends Command
{
    protected function configure() : void
    {
        $this->setDefinition(new InputDefinition([new InputOption('id', null, InputOption::VALUE_REQUIRED)]));
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $id = $input->getOption('id');
        if ($id === null || $id === '') {
            echo 'invalid id';
            return Command::INVALID;
        }

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
                'i' => $id
            ]
        ]);
        
        $bodyString = (string)$response->getBody();
        $bodyObject = json_decode($bodyString);
        $response = $bodyObject->Response;
        if ($response === 'False') {
            echo 'not found';
            return Command::SUCCESS;
        }
        echo $bodyObject->Title;
        
        return Command::SUCCESS;
    }
}
