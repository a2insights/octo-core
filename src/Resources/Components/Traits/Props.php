<?php

namespace Octo\Resources\Components\Traits;

use Illuminate\Support\Str;
use Symfony\Component\Mime\Exception\LogicException;

trait Props
{
    /**
     * The component props.
     *
     * @var array
     */
    protected $props = [];

    /**
     * The props that should be cast.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The cast types that should be use.
     *
     * @var array
     */
    private static $primitiveCastTypes = [
        'objects'
    ];

    /**
     * Cast the props contained in casts array keys.
     *
     * @return void
     */
    protected function castProps()
    {
        collect($this->casts)
            ->each(
                fn($prop, $key) => $this->castProp($key)
            );
    }

    /**
     * Cast property to objects.
     *
     * @param $key
     * @return void
     */
    private function castToObjects($key)
    {
        if (is_array($this->{$key}))
            $this->{$key} = json_decode(json_encode($this->{$key}));
    }

    /**
     * Cast a prop by key.
     *
     * @param $key
     * @return mixed
     */
    protected function castProp($key)
    {
        $castType = $this->casts[$key];

        if (!in_array($castType, self::$primitiveCastTypes)) {
            throw new LogicException("Cast $key invalid");
        }

        // Here we calling the cast method, but it's only a workarround
        return $this->{"castTo" . Str::Title($castType)}($key);
    }
}
