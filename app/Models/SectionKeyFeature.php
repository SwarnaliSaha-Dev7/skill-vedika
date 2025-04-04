<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionKeyFeature extends Model
{
    use HasFactory;

    protected $fillable = ['title','desc','desc_image','lebel1','content1','lebel2','content2','lebel3','content3','lebel4','content4'];
}
