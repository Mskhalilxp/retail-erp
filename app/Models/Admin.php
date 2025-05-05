<?php

namespace App\Models;

use App\Enums\EmployeeRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $guarded = ['password_confirmation'];
    protected $appends = ['role_name'];
    protected $casts = ['created_at' => 'date:Y-m-d', 'updated_at' => 'date:Y-m-d'];

    protected static function booted()
    {
        static::addGlobalScope(function($query){
            if ( session()->get('auth_id') != null )
                $query->where('email','!=','support@erp.com');
        });
    }

    public function getRoleNameAttribute()
    {
        return __(ucfirst(str_replace('_',' ',EmployeeRole::tryFrom($this->attributes['role'])->name)));
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
