<?php

namespace Octo\Tests;

use Octo\Resources\Components\Component;

class ComponentTest extends TestCase
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
        $component = new ComponentTestable('Amanda', 23, $this->dataArray);

        $properties = $component->data();

        $this->assertEquals(23, $properties['age']);
    }
}

class ComponentTestable extends Component
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
