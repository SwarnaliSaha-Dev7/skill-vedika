<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseContact extends Model
{
    use HasFactory;

    protected $fillable = ['course_id','student_name','student_email','calling_code','phone','message','is_terms_and_condition_checked_by_student'];

    public function courseDtls(){
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

}
