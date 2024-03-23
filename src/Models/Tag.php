<?php

namespace LaraZeus\Tartarus\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use LaraZeus\Chaos\Concerns\ChaosModel;
use LaraZeus\Tartarus\Models\Concerns\ForCompany;
use LaraZeus\Tartarus\TartarusPlugin;

class Tag extends \Spatie\Tags\Tag
{
    use ChaosModel;
    use ForCompany;
    use SoftDeletes;

    public function getCasts(): array
    {
        return [
            'type' => TartarusPlugin::getModel('TagType')
        ];
    }
}
