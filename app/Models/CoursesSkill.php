<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CoursesSkill extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'skill_id'];

    public $timestamps = true;

    // protected $appends = ['name']; // Adds 'skill_ids' to API response

    public function skillDtls(): HasOne
    {
        return $this->hasOne(Skill::class, 'id', 'skill_id');
        // return $this->hasOne(Skill::class);
    }

    // public function skillDtls()
    // {
    //     return $this->belongsTo(Skill::class, 'skill_id', 'id');
    // }

    // public function getSkillAttribute()
    // {
    //     return $this->skillDtls->pluck('name');
    // }

    // public function course(): BelongsTo
    // {
    //     return $this->belongsTo(Course::class);
    // }

    // public function skillName(): HasMany
    // {
    //     return $this->hasMany(Skill::class,'id', 'skill_id');
    //     // return $this->hasMany(Comment::class, 'foreign_key', 'local_key');
    // }
}
