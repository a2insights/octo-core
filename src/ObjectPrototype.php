<?php

namespace Octo;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Octo\Contracts\Resources\Arrayable;
use ReflectionMethod;
use ReflectionNamedType;

abstract class ObjectPrototype implements Arrayable
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
     * The cache of the "Attribute" return type marked mutated, settable attributes for each class.
     *
     * @var array
     */
    protected static $setAttributeMutatorCache = [];

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

    /**
     * Fill the object with an array of attributes.
     *
     * @param  array  $attributes
     * @return $this
     */
    protected function fill(array $attributes)
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
     * Get the value of an attribute.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function getMutatedAttributeValue($key, $value)
    {
        return $this->{'set'.Str::studly($key).'Attribute'}($value);
    }

    /**
     * Determine if a set mutator exists for an attribute.
     *
     * @param  string  $key
     * @return bool
     */
    public function hasSetMutator($key)
    {
        return method_exists($this, 'set'.Str::studly($key).'Attribute');
    }

    /**
     * setAttribute in object.
     *
     * @return void
     */
    protected function setAttribute($key, $value)
    {
        if ($this->hasSetMutator($key)) {
            $this->{$key} = $this->getMutatedAttributeValue($key, $value);
        } else {
            $this->{$key} = $value;
        }
    }

    /**
     * getAttribute in object.
     *
     * @return array $attributes
     */
    protected function getAttributes()
    {
        $attributes = [];

        foreach ($this->attributes as $key => $value) {
            $attributes[$key] = $this->{$key};
        }

       return $attributes;
    }

    /**
     * setAppends in object.
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

    /**
     * Normalize attributes from array
     *
     * @param void
     */
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

    /**
     * Set only stricts attributes
     *
     * @param void
     */
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
}
