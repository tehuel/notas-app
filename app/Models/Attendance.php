<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    /** @use HasFactory<\Database\Factories\AttendanceFactory> */
    use HasFactory;

    protected $fillable = [
        'present',
        'status',
        'note',
    ];

    protected $casts = [
        'present' => 'boolean',
    ];

    public function scopePresent($query)
    {
        return $query->where('present', true);
    }

    public function scopeInClassDays($query, array $classDayIds)
    {
        return $query->whereIn('class_day_id', $classDayIds);
    }

    public function classDay(): BelongsTo
    {
        return $this->belongsTo(ClassDay::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
