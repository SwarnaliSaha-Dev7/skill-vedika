<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageHome extends Model
{
    use HasFactory;

    protected $fillable = ['title1','desc1','img1','title2','desc2','course_type_tag1','course_type_tag2','course_type_tag3','start_building_your_carrer_title','start_building_your_carrer_img','blog_list_title','review_heading'];
}
