<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStatus extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
