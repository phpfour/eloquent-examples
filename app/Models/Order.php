<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends BaseEloquentModel
{
    use HasFactory;

    protected $fillable = ['customer_name', 'total_amount', 'status'];

    public function orderLines(): HasMany
    {
        return $this->hasMany(OrderLine::class);
    }

    public function shipping(): HasOne
    {
        return $this->hasOne(Shipping::class);
    }
}
