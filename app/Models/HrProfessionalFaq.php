<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrProfessionalFaq extends Model
{
    use HasFactory;

    protected $fillable = ['question','answer'];
}
