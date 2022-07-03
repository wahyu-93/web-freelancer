<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function userBuyer()
    {
        return $this->belongsTo(User::class, 'buyer_id', 'id');
    }

    public function userFreelancer()
    {
        return $this->belongsTo(User::class, 'freelance_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id', 'id');
    }
}
