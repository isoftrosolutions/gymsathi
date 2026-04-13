<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'name',
        'slug',
        'status',
        'plan',
        'settings',
    ];

    /** @var list<string> */
    protected $casts = [
        'settings' => 'array',
    ];

    /**
     * Get the users for the tenant.
     * 
     * @return HasMany<User, $this>
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
