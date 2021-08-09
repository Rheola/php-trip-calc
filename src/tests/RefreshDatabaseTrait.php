<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;

trait RefreshDatabaseTrait
{
    protected $em;

    public function startTransaction()
    {
        $this->em = self::$kernel->getContainer()->get('doctrine')->getManager();
        $this->em->getConnection()->beginTransaction();
    }

    public function databaseCreate()
    {
        $app = new Application(self::$kernel);
        $command = $app->find('doctrine:database:create');

        $greetInput = new ArrayInput(
            [
                '--if-not-exists' => 1
            ]
        );
        $greetInput->setInteractive(false);
        $output = new ConsoleOutput();
        $returnCode = $command->run($greetInput, $output);
        if ($returnCode !== 0) {
//            throw new \Exception("Error through database creation");
        }
    }

    public function loadMigrations()
    {
        $app = new Application(self::$kernel);
        $command = $app->find('doctrine:migrations:migrate');

        $greetInput = new ArrayInput([]);
        $greetInput->setInteractive(false);
        $output = new ConsoleOutput();
        $returnCode = $command->run($greetInput, $output);
        if ($returnCode !== 0) {
            throw new \Exception("Error through migration call");
        }
    }

    public function rollbackTransaction()
    {
        $this->em->getConnection()->rollBack();
    }
}