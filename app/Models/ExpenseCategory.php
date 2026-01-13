<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

class ExpenseCategory extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use Auditable;

    //
}
