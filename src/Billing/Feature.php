<?php

namespace Octo\Billing;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;

class Feature implements Arrayable
{
    use Concerns\HasData;
    use Concerns\IsIdentifiable;

    /**
     * The value of this feature.
     * Used to track down the usability
     * of this specific feature at the subscription level.
     *
     * @var int|float
     */
    protected $value = 0;

    /**
     * Mark the feature as being resettable.
     *
     * @var bool
     */
    protected $resettable = true;

    /**
     * The callback to call when syncing the current usage.
     *
     * @var array[Closure]
     */
    protected $calcule;

    /**
     * The model that owns this feature.
     *
     * @var null|Model
    */
    protected $model;

    /**
     * Create a new feature builder.
     *
     * @param string  $name
     * @param string|int $id
     * @param int|float $value
     * @param null|string $model
     * @param null|Closure  $calcule
     * @return void
     */
    public function __construct(string $name, $id, $value = 0, $model = null, Closure $calcule = null)
    {
        $this->name($name);
        $this->id($id);
        $this->value($value);
        $this->model($model);
        $this->calcule = $calcule;
    }

    /*
    *  Get the feature mode.
    *
    * @param null|string $model
    * @return $this
    */
    public function model($model)
    {
        $this->model = $model;

        return $this;
    }


    /**
     * Set a new value for the usability.
     *
     * @param int|float  $value
     * @return self
     */
    public function value($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Set the feature as unlimited value.
     *
     * @return self
     */
    public function unlimited()
    {
        $this->value = -1;

        return $this;
    }

    /**
     * Mark the feature as not resettable.
     *
     * @return self
     */
    public function notResettable()
    {
        $this->resettable = false;

        return $this;
    }

    /**
     * Get the feature value.
     *
     * @return int|float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get the feature model.
     *
     * @return null|string
     */
    public function getModel()
    {
        return $this->model;
    }

    /*
    * Calculate the feature usage for the each increment.
    *
    * @param Model $model
    */
    public function calculeUsage(Model $model)
    {
        if ($this->calcule instanceof Closure) {
            return  $this->calcule->__invoke($model);
        }

        return 1;
    }

    /**
     * Check if this feature is resettable after each billing cycle.
     *
     * @return bool
     */
    public function isResettable(): bool
    {
        return $this->resettable;
    }

    /**
     * Check if the feature has unlimited uses.
     *
     * @return bool
     */
    public function isUnlimited(): bool
    {
        return $this->getValue() < 0;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'model' => $this->getModel(),
            'description' => $this->getDescription(),
            'value' => $this->isUnlimited() ? '∞' : $this->getValue(),
            'unlimited' => $this->isUnlimited(),
            'resettable' => $this->isResettable(),
        ];
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
}
