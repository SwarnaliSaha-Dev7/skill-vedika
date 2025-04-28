<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingManagement extends Model
{
    use HasFactory;

    protected $table = 'setting_managements';

    protected $fillable = ['site_url', 'title', 'default_course_image', 'default_course_small_icon', 'default_blog_image', 'default_demo_video_url', 'phone_no', 'email', 'location_1_address', 'location_2_address', 'facebook_url', 'instagram_url', 'linkedIn_url', 'youtube_url', 'twitter_url', 'header_logo', 'footer_logo', 'footer_short_description', 'footer_copy_right', 'footer_quick_links', 'footer_support', 'footer_disclaimer', 'footer_category', 'google_analytics', 'default_color_theme', 'current_color_theme'];
}
