<?php

namespace App\Models;

use LaraZeus\Tartarus\Models\Concerns\ForCompany;

class Activity extends \Spatie\Activitylog\Models\Activity
{
    use ForCompany;
}
