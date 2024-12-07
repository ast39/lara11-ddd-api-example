<?php

namespace App\Command;

class CommandClass {

    public function __construct() {}

    public function toArray(): array
    {
        return collect($this)
            ->filter(function ($value) {
                return !is_null($value);
            })
            ->toArray();
    }
}
