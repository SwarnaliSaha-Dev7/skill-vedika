<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogContact extends Model
{
    use HasFactory;

    protected $fillable = ['blog_id','student_name','student_email','calling_code','phone','message','is_terms_and_condition_checked_by_student'];

    public function blogDtls(){
        return $this->belongsTo(Blog::class, 'blog_id', 'id');
    }
}
