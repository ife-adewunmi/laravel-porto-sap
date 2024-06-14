<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Unit\Loaders;

use AlxDorosenco\PortoForLaravel\Loaders\MigrationsLoader;
use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class MigrationsLoaderTraitTest extends TestCase
{
    /**
     * @var __anonymous@408
     */
    private $trait;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->trait = new class {
            use MigrationsLoader {
                getMigrationsFromShip as public;
                getMigrationsFromContainers as public;
            }
        };
    }

    public function testGetMigrationsFromShipMethod(): void
    {
        $this->assertIsString($this->trait->getMigrationsFromShip());
    }

    public function testGetMigrationsFromContainersMethod(): void
    {
        $this->assertIsArray($this->trait->getMigrationsFromContainers());
    }
}