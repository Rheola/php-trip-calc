<?php


namespace App\Tests;


trait BootKernel
{

    public function setUp(): void {
        self::bootKernel();
        if (method_exists($this,'databaseCreate')) {
            $this->databaseCreate();
        }

        if (method_exists($this,'startTransaction')) {
            $this->startTransaction();
        }

        if (method_exists($this,'loadMigrations')) {
            $this->loadMigrations();
        }

        if (method_exists($this,'loadFixtures')) {
            $this->loadFixtures();
        }

        if (method_exists($this,'loadEntityManager')) {
            $this->loadEntityManager();
        }

    }

    public function tearDown(): void
    {
        parent::tearDown();
        if (method_exists($this, 'rollbackTransaction')) {
            $this->rollbackTransaction();
        }
    }

}