<?php

// src/Command/CreateUserCommand.php
namespace App\Command;

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
        echo 'succes';
        return Command::SUCCESS;
    }
}

$application = new Application();
$application->add( new HelloworldCommand());
$application->run();