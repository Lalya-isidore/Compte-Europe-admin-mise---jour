<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayoutMethod extends Model
{
    protected $fillable = ['user_id', 'operator', 'holder_name', 'phone_number'];

    const OPERATORS = ['MTN Money', 'Moov Money', 'Celtiis Money', 'Coris Money'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
