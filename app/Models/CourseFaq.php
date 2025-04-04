<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class CourseFaq extends Model
{
    use HasFactory;

    protected $fillable = ['course_id','type','question','answer'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
