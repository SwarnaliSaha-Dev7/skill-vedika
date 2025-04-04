<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageTermsAndCondition extends Model
{
    use HasFactory;

    protected $fillable = ['title1','small_desc','title2','image','content'];
}
