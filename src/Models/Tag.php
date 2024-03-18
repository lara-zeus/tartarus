<?php

namespace LaraZeus\Tartarus\Models;

use LaraZeus\Tartarus\Enums\TagTypes;
use LaraZeus\Tartarus\Models\Concerns\ForCompany;
use LaraZeus\Chaos\Concerns\ChaosModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends \Spatie\Tags\Tag
{
    use ChaosModel;
    use ForCompany;
    use SoftDeletes;

    protected $casts = [
        'type' => TagTypes::class,
    ];
}
