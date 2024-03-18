<?php

namespace LaraZeus\Tartarus\Models;

use Illuminate\Database\Eloquent\Model;
use LaraZeus\Chaos\Concerns\ChaosModel;
use LaraZeus\Tartarus\Models\Concerns\ForCompany;

class CompanyInvitation extends Model
{
    use ChaosModel;
    use ForCompany;
}
