<?php

namespace LaraZeus\Tartarus\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use LaraZeus\Chaos\Concerns\ChaosModel;
use LaraZeus\Tartarus\Enums\TagTypes;
use LaraZeus\Tartarus\Models\Concerns\ForCompany;

class Tag extends \Spatie\Tags\Tag
{
    use ChaosModel;
    use ForCompany;
    use SoftDeletes;

    protected $casts = [
        'type' => TagTypes::class,
    ];
}
