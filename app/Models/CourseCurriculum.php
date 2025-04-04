<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCurriculum extends Model
{
    use HasFactory;

    protected $table = 'course_curriculums';

    protected $fillable = ['course_id','curriculum','image'];
}
