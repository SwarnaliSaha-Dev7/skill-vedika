<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
                            'category_id',
                            'course_name',
                            'duration_value',
                            'duration_unit',
                            'batch_type',
                            'teaching_mode',
                            'fee',
                            'fee_unit',
                            'demo_video_url',
                            'course_desc',
                            'course_overview',
                            'overview_img',
                            'course_content',
                            'course_logo',
                            'rating',
                            'total_students_contacted',
                            'status',
                            'top_tranding_course',
                            'is_popular',
                            'is_free',
                            'featured',
                            'slug',
                            'mete_title',
                            'meta_description',
                            'search_tag',
                            'meta_keyword',
                            'seo1',
                            'seo2',
                            'seo3',
                            'feature_field1',
                            'feature_field2',
                            'feature_field3'
                        ];

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'courses_skills', 'course_id', 'skill_id');
                    // ->withTimestamps();
    }

    public function categoryDtls(): belongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function courseCurriculums(): HasMany
    {
        return $this->hasMany(CourseCurriculum::class);
    }

    public function courseTopics(): HasMany
    {
        return $this->hasMany(CourseTopic::class);
    }

    public function courseReviews(): HasMany
    {
        return $this->hasMany(CourseReview::class);
    }

    public function courseFaqs(): HasMany
    {
        return $this->hasMany(CourseFaq::class);
    }

}
