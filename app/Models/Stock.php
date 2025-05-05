<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;

    protected $guarded = ['products'];
    protected $appends = ['status_name'];
    protected $casts = ['created_at' => 'date:Y-m-d', 'updated_at' => 'date:Y-m-d'];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    public function getStatusNameAttribute()
    {
        return __(ucfirst(str_replace('_', ' ', \App\Enums\StockStatus::tryFrom($this->attributes['status'])->name)));
    }
}
