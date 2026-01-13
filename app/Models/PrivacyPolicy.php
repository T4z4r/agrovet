<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Auditable;

class PrivacyPolicy extends Model
{
    use HasFactory, Auditable;

    protected $fillable = ['title', 'content', 'is_active'];
}
