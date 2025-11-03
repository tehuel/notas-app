<?php

namespace App\Models;

use App\Enums\GradeTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Grade extends Model
{
    /** @use HasFactory<\Database\Factories\GradeFactory> */
    use HasFactory;

    protected $fillable = [
        'type',
        'value',
        'comment',
    ];

    protected $casts = [
        'type' => GradeTypeEnum::class,
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    public function gradable(): MorphTo
    {
        return $this->morphTo(); // Can be Student or StudentGroup
    }
}
