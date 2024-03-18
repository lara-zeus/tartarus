<?php

namespace LaraZeus\Tartarus\Settings;

class Company
{
    public static function settings(): array
    {
        return [
            'country',
            'state',
            'city',
        ];
    }
}
