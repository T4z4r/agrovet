<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Auditable;

class Contact extends Model
{
    use HasFactory, Auditable;
    protected $fillable = ['type', 'value'];
}
