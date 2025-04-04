<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteFaq extends Model
{
    use HasFactory;
    protected $fillable = ['type','question','answer'];
}
