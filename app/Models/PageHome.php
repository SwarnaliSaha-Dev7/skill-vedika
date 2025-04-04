<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageHome extends Model
{
    use HasFactory;

    protected $fillable = ['title1','desc1','img1','title2','desc2','start_building_your_carrer_title','start_building_your_carrer_img','blog_list_title'];
}
