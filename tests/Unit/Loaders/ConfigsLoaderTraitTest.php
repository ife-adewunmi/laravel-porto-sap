<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Unit\Loaders;

use AlxDorosenco\PortoForLaravel\Loaders\ConfigsLoader;
use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class ConfigsLoaderTraitTest extends TestCase
{
    /**
     * @var __anonymous@402
     */
    private $trait;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->trait = new class {
            use ConfigsLoader {
                getConfigsFromContainers as public;
                getConfigsFromShip as public;
                getConfigsFromPackage as public;
            }
        };
    }

    public function testGetAliasesFromContainersLoadersMethod(): void
    {
        $this->assertIsArray($this->trait->getConfigsFromContainers());
    }

    public function testGetConfigsFromShipMethod(): void
    {
        $this->assertIsArray($this->trait->getConfigsFromShip());
    }

    public function testConfigsFromPackageMethod(): void
    {
        $this->assertIsArray($this->trait->getConfigsFromPackage());
    }
}