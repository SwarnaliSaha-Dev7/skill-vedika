<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageAboutUs extends Model
{
    use HasFactory;

    protected $fillable = ['title1','small_desc','small_desc_img','title2','content','content_image'];
}
