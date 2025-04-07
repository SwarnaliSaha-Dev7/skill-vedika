<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionKeyFeature extends Model
{
    use HasFactory;

    protected $fillable = ['title','desc','desc_image','lebel1','lebel1_image','content1','lebel2','lebel2_image','content2','lebel3','lebel3_image','content3','lebel4','lebel4_image','content4'];
}
