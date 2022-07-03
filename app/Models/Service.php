<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function anvantageUsers()
    {
        return $this->hasMany(AdvantageUser::class);
    }

    public function taglines()
    {
        return $this->hasMany(Tagline::class);
    }

    public function advantageServices()
    {
        return $this->hasMany(AdvantageService::class);
    }

    public function thumbnails()
    {
        return $this->hasMany(Thumbnail::class);
    }
    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
