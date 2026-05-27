<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ContractHistory extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'is_test',
        'stored_filename',
        'display_name',
        'metadata',
        'expires_at',
    ];

    protected $casts = [
        'is_test'    => 'boolean',
        'metadata'   => 'array',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function storagePath(): string
    {
        return 'contracts/' . $this->user_id . '/' . $this->stored_filename;
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function deleteFile(): void
    {
        Storage::disk('local')->delete($this->storagePath());
    }

    public static function saveContract(int $userId, string $type, string $pdfContent, string $displayName, array $metadata, bool $isTest): self
    {
        $dir = 'contracts/' . $userId;
        Storage::disk('local')->makeDirectory($dir);

        $filename = $type . '-' . now()->format('Ymd-His') . '-' . substr(md5(uniqid()), 0, 8) . '.pdf';
        Storage::disk('local')->put($dir . '/' . $filename, $pdfContent);

        return static::create([
            'user_id'         => $userId,
            'type'            => $type,
            'is_test'         => $isTest,
            'stored_filename' => $filename,
            'display_name'    => $displayName,
            'metadata'        => $metadata,
            'expires_at'      => now()->addDays(30),
        ]);
    }
}
