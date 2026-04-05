<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponCollection extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kind',
        'lang',
        'count',
        'token',
        'status',
        'cost',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coupons()
    {
        return $this->hasMany(CollectedCoupon::class, 'collection_id');
    }
}
