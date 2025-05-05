<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = ['created_at' => 'date:Y-m-d', 'updated_at' => 'date:Y-m-d'];
}
