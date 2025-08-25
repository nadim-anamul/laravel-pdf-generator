<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'registration_note',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
            'is_approved' => 'boolean',
            'is_super_user' => 'boolean',
            'approved_at' => 'datetime',
            'must_change_password' => 'boolean',
            'password_changed_at' => 'datetime',
        ];
    }

    /**
     * Check if user is approved
     */
    public function isApproved(): bool
    {
        return $this->is_approved;
    }

    /**
     * Check if user is super user
     */
    public function isSuperUser(): bool
    {
        return $this->is_super_user;
    }

    /**
     * Get the user who approved this user
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get users approved by this user
     */
    public function approvedUsers()
    {
        return $this->hasMany(User::class, 'approved_by');
    }

    /**
     * Scope to get only approved users
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope to get pending approval users
     */
    public function scopePendingApproval($query)
    {
        return $query->where('is_approved', false);
    }

    /**
     * Scope to get super users
     */
    public function scopeSuperUsers($query)
    {
        return $query->where('is_super_user', true);
    }

    /**
     * Check if user must change password
     */
    public function mustChangePassword(): bool
    {
        return $this->must_change_password;
    }

    /**
     * Get the user who reset this user's password
     */
    public function passwordResetBy()
    {
        return $this->belongsTo(User::class, 'password_reset_by');
    }

    /**
     * Get users whose passwords were reset by this user
     */
    public function passwordResetsPerformed()
    {
        return $this->hasMany(User::class, 'password_reset_by');
    }

    /**
     * Mark user password as changed
     */
    public function markPasswordChanged()
    {
        $this->update([
            'must_change_password' => false,
            'password_changed_at' => now(),
            'password_reset_by' => null,
            'password_reset_reason' => null,
        ]);
    }
}
