<?php

namespace App\Models;

use LaraZeus\Chaos\Concerns\ChaosModel;
use LaraZeus\Tartarus\Models\Concerns\ForCompany;

class Email extends \RickDBCN\FilamentEmail\Models\Email
{
    use ChaosModel;
    use ForCompany;
}
