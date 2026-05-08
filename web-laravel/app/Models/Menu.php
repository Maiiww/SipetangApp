<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';

    protected $fillable = [
        'title',
        'route_name',
        'icon',
        'allowed_roles',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForRole($query, $role)
    {
        return $query->whereRaw('FIND_IN_SET(?, allowed_roles)', [$role]);
    }

    public function getAllowedRolesArrayAttribute()
    {
        return array_filter(array_map('trim', explode(',', $this->allowed_roles)));
    }
}
