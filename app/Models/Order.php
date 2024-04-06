<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Order extends Model
{
    use HasFactory, softDeletes;

    protected $guarded = ['id'];

    public function order_details(): HasMany
    {
        return $this->hasMany(OrderDetails::class);
    }

    public function customer(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'customer_id');
    }
}
