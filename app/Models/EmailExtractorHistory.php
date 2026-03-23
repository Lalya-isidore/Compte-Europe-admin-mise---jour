<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailExtractorHistory extends Model
{
    use HasFactory;

    protected $table = 'email_extractor_history';

    protected $fillable = [
        'user_id',
        'separator',
        'result_count',
        'emails',
        'source_preview',
    ];

    protected $casts = [
        'result_count' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
