<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

class Brand extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use Auditable;

    //
}
