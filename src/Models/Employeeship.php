<?php

namespace LaraZeus\Tartarus\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use LaraZeus\Chaos\Concerns\ChaosModel;
use LaraZeus\Tartarus\Models\Concerns\ForCompany;

class Employeeship extends Pivot
{
    use ChaosModel;
    use ForCompany;

    protected $table = 'company_user';

    public $incrementing = true;

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }
}
