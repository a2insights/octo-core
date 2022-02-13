<?php

namespace Octo\Resources\Livewire\Concerns;

use Illuminate\Support\Facades\Validator;

trait ValidateState
{
    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return $this->rules;
    }

    /**
     * Validate and get the validation messages.
     *
     * @return array
     */
    public function validate($rules = null, $messages = [], $attributes = [])
    {
        return Validator::make($this->state, $rules ?? $this->rules(), $messages)->validateWithBag($this::class);
    }
}
