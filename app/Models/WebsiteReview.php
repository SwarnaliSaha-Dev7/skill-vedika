<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteReview extends Model
{
    use HasFactory;

    protected $fillable = ['reviewer_name','rating','review'];
}
