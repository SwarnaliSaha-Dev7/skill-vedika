<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionJobAssistanceProgram extends Model
{
    use HasFactory;

    protected $fillable = ['title','short_desc','lebel1','content1','lebel2','content2','lebel3','content3','lebel4','content4','lebel5','content5','lebel6','content6','icon1','icon2','icon3','icon4','icon5','icon6'];
}
