<?php

namespace Octo\Resources\Objects;

use Illuminate\Support\Str;
use Octo\Contracts\Resources\Arrayable;

abstract class ObjectAbstract implements Arrayable
{
    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * Create a new Object instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    /**
     * Fill the object with an array of attributes.
     *
     * @param  array  $attributes
     * @return $this
     */
    public function fill(array $attributes)
    {
        $toFill = array_merge($this->attributes, $attributes);

        $this->attributes = [];

        $this->attributes = collect($toFill)
            ->map(function ($value, $key) {
                if (!is_int($key)){
                    $this->setAttribute($key, $value);
                    return $value;
                }
                return null;
            })
            ->whereNotNull()
            ->toArray();

        $this->setAppends();

        return $this;
    }

    /**
     * setAttribute in object.
     *
     * @return void
     */
    protected function setAttribute($key, $value)
    {
        $this->{$key} = $value;
    }

    /**
     * getAttribute in object.
     *
     * @return array $this->attributes
     */
    protected function getAttributes()
    {
       return $this->attributes;
    }

    /**
     * set appends in object.
     *
     * @return void
     */
    protected function setAppends()
    {
        foreach ($this->appends as $append) {
            $getter = Str::camel("get_$append"."_attribute");
            $this->setAttribute($append, $this->$getter());
        }
    }

    /**
     * object to array
     *
     * @param null $data
     * @return array
     */
    public function toArray($data = null): array
    {
        return json_decode(json_encode($this->getAttributes()),TRUE);
    }
}
