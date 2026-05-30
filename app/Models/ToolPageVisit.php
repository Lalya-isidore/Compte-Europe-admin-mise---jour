<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ToolPageVisit extends Model
{
    protected $fillable = ['user_id', 'tool_slug', 'ip_address'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function record(string $toolSlug): void
    {
        if (!Auth::check()) return;
        try {
            static::create([
                'user_id'    => Auth::id(),
                'tool_slug'  => $toolSlug,
                'ip_address' => request()->ip(),
            ]);
        } catch (\Exception $e) {
            Log::error("ToolPageVisit::record failed for [{$toolSlug}]: " . $e->getMessage());
        }
    }
}
