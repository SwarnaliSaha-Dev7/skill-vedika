<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageContactUs extends Model
{
    use HasFactory;

    protected $fillable = ['title1','desc','desc_img','title2','email_label','email_address','phone_label','phone_no','location1_label','location1_address','location2_label','location2_address'];
}
