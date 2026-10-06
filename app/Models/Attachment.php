<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attachment extends Model
{
    protected $fillable = ['post_id', 'title', 'file_path', 'file_size', 'mime_type', 'download_count'];
    protected $casts = ['file_size' => 'integer', 'download_count' => 'integer'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}