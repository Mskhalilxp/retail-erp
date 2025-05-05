<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['products'];
    protected $appends = ['status_name'];
    protected $casts = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d',
        'city' => 'array',
        'region' => 'array',
        'shipping_status' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            $order->created_by = auth('admin')->user()->id;
        });
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'actual_price', 'sale_price');
    }

    public function getStatusNameAttribute()
    {
        return __(ucfirst(str_replace('_', ' ', \App\Enums\OrderStatus::tryFrom($this->attributes['status'])->name)));
    }

    public function socialEmployee()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function warehouseEmployee()
    {
        return $this->belongsTo(Admin::class, 'prepared_by');
    }

    public function contactEmployee()
    {
        return $this->belongsTo(Admin::class, 'client_contacted_by');
    }
}
