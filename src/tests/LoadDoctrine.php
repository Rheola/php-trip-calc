<?php


namespace App\Tests;


use Doctrine\Persistence\ObjectManager;

trait LoadDoctrine
{
    protected ObjectManager $entityManager;

    public function loadEntityManager() {
        $this->entityManager = self::$kernel->getContainer()->get('doctrine')->getManager();
    }
}