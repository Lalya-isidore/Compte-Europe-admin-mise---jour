<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'phone',
        'email',
        'password',
        'credit_user',
        'contrat_free_used',
        'code_parrainage',
        'parrain_id',
        'region',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'credit_user' => 'integer',
        ];
    }
    public function Compte()
    {
        return $this->hasMany(Compte::class);
    }
    
    public function comptes()
    {
        return $this->hasMany(Compte::class);
    }
    
    // Relations d'affiliation
    public function affiliation()
    {
        return $this->hasOne(Affiliation::class);
    }
    
    public function parrain()
    {
        return $this->belongsTo(User::class, 'parrain_id');
    }
    
    public function parraines()
    {
        return $this->hasMany(User::class, 'parrain_id');
    }

    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function isAfrique(): bool
    {
        return $this->region === 'afrique';
    }

    public function isEurope(): bool
    {
        return $this->region === 'europe';
    }
    
    /**
     * Send the password reset notification using our custom Markdown mail.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
    
}
