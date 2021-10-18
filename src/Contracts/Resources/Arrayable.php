<?php

namespace Octo\Contracts\Resources;

interface Arrayable
{
    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray($data): array;
}
