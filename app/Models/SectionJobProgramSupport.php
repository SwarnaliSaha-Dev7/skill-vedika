<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionJobProgramSupport extends Model
{
    use HasFactory;

    protected $fillable = ['title','desc','lebel1','lebel2','lebel3','image'];
}
