<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionLiveFreeDemo extends Model
{
    use HasFactory;

    protected $fillable = ['title','image','point1','point2','point3'];
}
