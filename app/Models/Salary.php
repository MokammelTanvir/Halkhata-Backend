<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Salary extends Model
{
    use HasFactory, softDeletes;

    protected $guarded = ['id'];

    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }

}
