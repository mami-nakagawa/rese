<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Shop extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'shop_id');
    }

    public function favorite_users()
    {
        return $this->belongsToMany(User::class, 'favorites', 'shop_id', 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
