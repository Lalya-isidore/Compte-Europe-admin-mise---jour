<?php
// app/Models/Compte.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Compte extends Model
{
    use HasFactory;

    // Remplacez $guarded par $fillable pour plus de sécurité
    protected $fillable = [
        'user_id', 'region', 'numerocompte', 'nom', 'prenom', 'email', 'password',
        'devise', 'lang', 'phone_number', 'country', 'address', 'photo_path',
        'account_balance', 'account_balance2', 'code_virement', 'account_type',
        'account_status', 'transfer_supported', 'card_number', 'cvv', 'iban',
        'start_percentage', 'end_percentage', 'failure_message', 'success_message', 'alert_email',
        'alert_sms', 'token', 'is_default',
        // nouveaux champs pour suppression automatique
        'is_auto_created', 'auto_deletes_at',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'alert_email' => 'boolean',
        'alert_sms' => 'boolean',
        'account_balance' => 'decimal:2',
        'account_balance2' => 'decimal:2',
        'is_auto_created' => 'boolean',
        'auto_deletes_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::updating(function (Compte $compte) {
            if ($compte->isDirty('code_virement')) {
                UnlockCode::where('compte_id', $compte->id)->delete();
            }
        });
    }

    public static function generateCardNumber()
    {
        $prefix = rand(4100, 4999);
        $suffix = rand(1000, 9999);
        return $prefix . str_repeat('*', 8) . $suffix;
    }

    public static function generateCVV()
    {
        return rand(100, 999);
    }
    public static function generatePassword()
    {
        return rand(100000, 999999);
    }
    public static function generateCodeVirement()
    {
        return rand(100000, 999999);
    }

    public static function generateAccountNumber()
    {
        do {
            $hash = substr(md5(Str::random(32) . microtime(true)), 0, 6);
        } while (static::where('numerocompte', $hash)->exists());

        return $hash;
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function rechargeTransactions()
    {
        return $this->hasMany(RechargeTransaction::class);
    }

    public function transactionHistories()
    {
        return $this->hasMany(TransactionHistory::class);
    }

    /**
     * Preferred locale for notifications sent to this notifiable.
     * Laravel's Notification system will call this method if present
     * to determine the locale used when rendering notifications.
     *
     * @param  mixed|null  $notification
     * @return string
     */
    public function preferredLocale($notification = null): string
    {
        return $this->lang ?? config('app.locale');
    }
    
    /**
     * Récupère l'URL de la photo ou retourne un avatar par défaut
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->photo_path) {
            // Si c'est une URL complète (avatar par défaut)
            if (filter_var($this->photo_path, FILTER_VALIDATE_URL)) {
                return $this->photo_path;
            }
            // Sinon, c'est un fichier uploadé
            return Storage::disk('public')->url($this->photo_path);
        }
        // Avatar par défaut (généré via ui-avatars)
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nom . ' ' . $this->prenom) . '&background=007bff&color=fff&size=50';
    }

    // (Les méthodes utilitaires existent déjà plus haut dans la classe.)
}

