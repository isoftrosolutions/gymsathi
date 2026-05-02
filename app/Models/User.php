<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\TenantScoped;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'tenant_id', 'platform_role', 'role_id', 'phone', 'address', 'emergency_contact', 'date_of_birth', 'gender', 'profile_picture', 'blood_group'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TenantScoped;

    /**
     * Get the role assigned to the user.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the tenant that the user belongs to.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get member packages for this user.
     */
    public function memberPackages(): HasMany
    {
        return $this->hasMany(MemberPackage::class);
    }

    /**
     * Get active member package.
     */
    public function activeMemberPackage(): HasOne
    {
        return $this->hasOne(MemberPackage::class)
            ->where('status', 'active')
            ->whereDate('end_date', '>=', now())
            ->latest('end_date');
    }

    /**
     * Check if the user has a specific role by slug.
     */
    public function hasRole(string $role): bool
    {
        return $this->role?->slug === $role;
    }

    /**
     * Check if the user has a specific permission by slug.
     */
    public function hasPermission(string $permission): bool
    {
        if ($this->platform_role === 'super_admin') {
            return true;
        }

        return $this->role?->permissions->contains('slug', $permission) ?? false;
    }

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
            'date_of_birth' => 'date',
        ];
    }
}
