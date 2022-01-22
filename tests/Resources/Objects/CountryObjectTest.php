<?php

namespace Octo\Tests\Resources\Objects;

use Octo\Country;
use Octo\Tests\TestCase;

class CountryObjectTest extends TestCase
{
    public function testObjectData()
    {
        $country = new Country();

        $expected = json_decode(file_get_contents(__DIR__.'/data/countries.json'), true);
        $given = $country->all()->map(fn($n) => $n->toArray())->toArray();

        $this->assertTrue($expected == $given);
    }
}
