<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectedCoupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'collection_id',
        'code',
        'status',
    ];

    public function collection()
    {
        return $this->belongsTo(CouponCollection::class, 'collection_id');
    }
}
