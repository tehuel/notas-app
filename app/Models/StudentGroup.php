<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class StudentGroup extends Model
{
    /** @use HasFactory<\Database\Factories\StudentGroupFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'order',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }

    public function grades(): MorphMany
    {
        return $this->morphMany(Grade::class, 'gradable');
    }
}
