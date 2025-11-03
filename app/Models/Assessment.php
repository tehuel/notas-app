<?php

namespace App\Models;

use App\Enums\AssessmentTypeEnum;
use App\Enums\GradeTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assessment extends Model
{
    /** @use HasFactory<\Database\Factories\AssessmentFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'grade_type',
        'order',
    ];

    protected $casts = [
        'type' => AssessmentTypeEnum::class,
        'grade_type' => GradeTypeEnum::class,
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class)
            ->orderBy('created_at', 'desc');
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function studentGroups(): HasMany
    {
        return $this->hasMany(StudentGroup::class);
    }

    public function scopeIndividual($query)
    {
        return $query->where('type', AssessmentTypeEnum::Individual);
    }

    public function isGroupAssessment(): bool
    {
        return $this->type === AssessmentTypeEnum::Group;
    }

    public function isIndividualAssessment(): bool
    {
        return $this->type === AssessmentTypeEnum::Individual;
    }
}
