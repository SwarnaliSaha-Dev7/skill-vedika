<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['category_id','title','image','short_content','full_content','status','slug','mete_title','mete_tag','meta_description','meta_keyword','search_tag','seo1','seo2','seo3'];

    public function categoryDtls(): BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
}
