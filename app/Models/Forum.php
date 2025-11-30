<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Forum extends Model
{
    use HasFactory;

    protected $fillable = [
        'chamber_id',
        'title',
        'description',
    ];

    public function chamber(): BelongsTo
    {
        return $this->belongsTo(Chamber::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ForumMessage::class);
    }
}







