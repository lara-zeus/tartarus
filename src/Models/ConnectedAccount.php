<?php

namespace LaraZeus\Tartarus\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use LaraZeus\Chaos\Concerns\ChaosModel;

class ConnectedAccount extends Model
{
    use ChaosModel;

    protected $table = 'connected_accounts';

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }
}
