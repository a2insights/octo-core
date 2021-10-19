<?php

namespace Octo;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Octo\Contracts\Resources\Arrayable;

abstract class ObjectAbstract implements Arrayable
{
    /**
     * The object attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * The object attribute's original state.
     *
     * @var array
     */
    protected $original = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * Strict properties
     *
     * @var bool
     */
    protected $strict = true;

    /**
     * Create a new Object instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->normalizeAttributes();
        $this->fill($attributes);
    }

    private function normalizeAttributes()
    {
        $normalized = [];

        foreach ($this->attributes as $key => $value) {
            if (!is_int($key)) {
                $normalized[$key] = $value;
            }

            if(is_string($value)){
                $normalized[$value] = null;
            }
        }

       $this->attributes = $normalized;
    }

    private function strictAttributes()
    {
        $attributes = [];

        foreach ($this->attributes as $key => $value) {
            if(Arr::exists($this->original, $key)){
                $attributes[$key] = $value;
            }
        }

        $this->attributes = $attributes;
    }

    /**
     * Fill the object with an array of attributes.
     *
     * @param  array  $attributes
     * @return $this
     */
    public function fill(array $attributes)
    {

        $this->original = $this->attributes;

        $this->attributes = array_merge($this->attributes, $attributes);

        if ($this->strict) {
            $this->strictAttributes();
        }

        foreach ($this->attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }

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
            $this->attributes[$append] = $this->$getter();
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
