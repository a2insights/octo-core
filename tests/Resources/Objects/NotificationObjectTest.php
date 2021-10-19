<?php

namespace Octo\Tests\Resources\Objects;

use Illuminate\Support\Facades\Route;
use Octo\Notification;
use Octo\Tests\TestCase;

class NotificationObjectTest extends TestCase
{
    public function testObjectGetters()
    {
        $route = Route::get('test/api')->name('teste_route_object_notification');

        $object = new Notification([
            'title' => 'user created',
            'description' => 'created',
            'route' => (new \Octo\Route(['name' => 'teste_route_object_notification']))
        ]);

        $this->assertTrue($object->title === 'user created');
        $this->assertTrue($object->route->name === $route->getName());
        $this->assertTrue($object->route->url === 'http://localhost/test/api');

        $expected = [
            'route' => [
                'name' => 'teste_route_object_notification',
                'params' => [],
                'url' => 'http://localhost/test/api'
            ],
            'title' => 'user created',
            'description' => 'created'
        ];

        $this->assertTrue($object->toArray() == $expected);
    }
}
