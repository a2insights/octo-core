<?php

namespace Octo\Tests\Resources\Objects;

use Illuminate\Support\Facades\Route;
use Octo\Tests\TestCase;

class RouteObjectTest extends TestCase
{
    public function testObjectGetters()
    {
        $route = Route::get('test/api/{id}')->name('teste_route_object');

        $object = new \Octo\Route([
            'name' => 'teste_route_object',
            'params' => [
                'id' => 1,
                'query' => true,
            ]
        ]);

        $this->assertTrue($object->name === $route->getName());
        $this->assertTrue($object->url === 'http://localhost/test/api/1?query=1');
    }
}
