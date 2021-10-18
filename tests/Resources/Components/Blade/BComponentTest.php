<?php

namespace Octo\Tests\Resources\Components\Blade;

use Octo\Resources\Components\Blade\BComponent;
use Octo\Tests\TestCase;

class BComponentTest extends TestCase
{
    private $dataArray = ([
        [
            'rua' => 'Av. Santos',
            'numero' => 23
        ],
        [
            'rua' => 'Av. Pereira',
            'numero' => 24
        ]
    ]);

    public function testPropertiesExposure()
    {
        $component = new BComponentTestable('Amanda', 23, $this->dataArray);

        $properties = $component->data();

        $this->assertEquals(23, $properties['age']);
    }
}

class BComponentTestable extends BComponent
{
    public $name;
    public $age;
    public $address;

    public $view = 'test';

    public function __construct($name, $age, $address)
    {
        $this->name = $name;
        $this->age = $age;
        $this->address = $address;
    }
}
