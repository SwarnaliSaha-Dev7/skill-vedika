<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseReview extends Model
{
    use HasFactory;

    protected $fillable = ['course_id','reviewer_name','rating','review'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
