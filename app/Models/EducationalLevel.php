<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EducationalLevel extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'is_active', 'sort_order'];
    protected $casts = ['is_active' => 'boolean', 'sort_order' => 'integer'];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}