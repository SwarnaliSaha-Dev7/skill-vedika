<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'courses_skills', 'skill_id', 'course_id')
                    ->withTimestamps();
    }
}
