<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transection extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'ship_id',
        'amount',
        'detail',
        'status',
        'expense_type',
    ];
}
