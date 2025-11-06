<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    protected $fillable = [
        'subject',
        'division',
        'orientation',
        'year',
        'description',
    ];

    protected $appends = [
        'color',
    ];

    public function getColorAttribute(): string
    {
        $hash = crc32($this->subject.$this->division.$this->orientation.$this->year);
        $hue = $hash % 360; // Hue between 0 and 359

        return "hsl($hue, 70%, 50%)";
    }

    public function getTitleAttribute(): string
    {
        return "{$this->subject} - {$this->division}, {$this->orientation} ({$this->year})";
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class)->withTimestamps();
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class)
            ->withTimestamps()
            ->withPivot('order')
            ->orderBy('pivot_order');
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class)
            ->orderBy('order', 'asc');
    }

    public function groupAssessments(): HasMany
    {
        return $this->hasMany(GroupAssessment::class)
            ->orderBy('order', 'asc');
    }

    public function classDays(): HasMany
    {
        return $this->hasMany(ClassDay::class)
            ->orderBy('class_date', 'asc');
    }
}
