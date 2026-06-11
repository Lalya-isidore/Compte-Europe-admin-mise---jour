<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ToolPageVisit extends Model
{
    protected $fillable = ['user_id', 'tool_slug', 'ip_address', 'session_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function record(string $toolSlug): void
    {
        try {
            static::create([
                'user_id'    => Auth::check() ? Auth::id() : null,
                'tool_slug'  => $toolSlug,
                'ip_address' => request()->ip(),
                'session_id' => session()->getId(),
            ]);
        } catch (\Exception $e) {
            Log::error("ToolPageVisit::record failed for [{$toolSlug}]: " . $e->getMessage());
        }
    }
}
