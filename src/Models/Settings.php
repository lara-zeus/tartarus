<?php

namespace LaraZeus\Tartarus\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use LaraZeus\Tartarus\Models\Concerns\ForCompany;

/**
 * @method static Builder<static> withoutCompany()
 */
class Settings extends Model
{
    use ForCompany;

    protected $casts = [
        'payload' => 'array',
    ];
}
