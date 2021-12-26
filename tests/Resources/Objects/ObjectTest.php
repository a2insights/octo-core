<?php

namespace Octo\Tests\Resources\Objects;

use Illuminate\Support\Facades\Route;
use Octo\ObjectPrototype;
use Octo\Tests\TestCase;

class ObjectTest extends TestCase
{
    public function testObjectGetters()
    {
        $route = Route::get('test/api/{id}')->name('teste_route_object');
        $objectChildChild = new ObjectChildChild(['name' => 'Ghu']);
        $objectChild = new ObjectChild(['name' => 'Bong', 'id' => 234, 'object_child' => $objectChildChild]);
        $object = new ObjectTestable([
            'dinamic_attribute' => 'tools',
            'name' => 'teste_route_object',
            'params' => [
                'id' => 1,
                'query' => true
            ],
            'object' => $objectChild
        ]);


        $expected = [
            'name' => 'teste_route_object',
            'id' => null,
            'dinamic_attribute' => 'tools',
            'url' => 'http://localhost/test/api/1?query=1',
            'params' => [
                'id' => 1,
                'query' => true,
            ],
            'object' => $objectChild->toArray()
        ];

        $this->assertTrue($objectChild->name === $object->object->name);
        $this->assertTrue($object->name === $route->getName());
        $this->assertTrue($object->toArray() == $expected);
        $this->assertTrue($object->url === 'http://localhost/test/api/1?query=1');
        $this->assertTrue($object->object === $objectChild);
    }
}

class ObjectTestable extends ObjectPrototype {

    protected $strict = false;

    protected $attributes = [
        'id', 'name', 'params' => []
    ];

    protected $appends = ['url'];

    public function getUrlAttribute()
    {
        return route($this->name, $this->params ?? []);
    }

    public function hasOneObject()
    {
        return ObjectChild::class;
    }

    public function HasManyObjects()
    {
        return ObjectChildChild::class;
    }
}

class ObjectChild extends ObjectPrototype {

    protected $attributes = [
        'name', 'id', 'object_child'
    ];
}

class ObjectChildChild extends ObjectPrototype {

    protected $attributes = [
        'name', 'id'
    ];

    public function toArray($data = null): array
    {
        return [
            'name' => $this->name,
            'id' => $this->id,
            '_type' => 2
        ];
    }
}
