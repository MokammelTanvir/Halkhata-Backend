<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Expense extends Model
{
    use HasFactory, softDeletes;

    protected $guarded = ['id'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id', 'id');
    }

    public function staff(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'staff_id');
    }
}
