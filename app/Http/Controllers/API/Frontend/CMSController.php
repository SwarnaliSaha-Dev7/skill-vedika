<?php

namespace App\Http\Controllers\API\Frontend;

use Validator;
use App\Models\Blog;
use App\Models\Course;
use App\Models\PageHome;
use App\Models\PopularTag;
use App\Models\WebsiteFaq;
use App\Models\PageAboutUs;
use Illuminate\Http\Request;
use App\Models\PageContactUs;
use App\Models\WebsiteReview;
use App\Models\SectionKeyFeature;
use App\Models\SettingManagement;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\SectionLiveFreeDemo;
use App\Http\Controllers\Controller;
use App\Models\PageBecomeInstructors;
use App\Models\PageTermsAndCondition;
use App\Http\Controllers\API\Exception;
use App\Models\SectionJobProgramSupport;
use App\Models\SectionJobAssistanceProgram;

class CMSController extends Controller
{

    public function aboutUsPage(Request $request): JsonResponse
    {
        try {

            $pageContent = PageAboutUs::first();

            if (!$pageContent) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $data['pageContent'] = $pageContent;
            $data['sectionKeyFeature'] = SectionKeyFeature::first();
            $data['reviews'] = WebsiteReview::select('id','review','created_at','updated_at')->get();

            $data['SectionLiveFreeDemo'] = SectionLiveFreeDemo::first();

            return sendSuccessResponse('About Us page details fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function termsAndConditionPage(Request $request): JsonResponse
    {
        try {

            $pageContent = PageTermsAndCondition::first();

            if (!$pageContent) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $data['pageContent'] = $pageContent;
            $data['SectionLiveFreeDemo'] = SectionLiveFreeDemo::first();

            return sendSuccessResponse('Terms and Conditions page details fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function contactUsPage(Request $request): JsonResponse
    {
        try {

            $pageContent = PageContactUs::first();

            if (!$pageContent) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $data['pageContent'] = $pageContent;
            $data['sectionLiveFreeDemo'] = SectionLiveFreeDemo::first();

            return sendSuccessResponse('Contact Us page details fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function websiteFaq(Request $request): JsonResponse
    {
        try {

            $data = WebsiteFaq::select('id','question','answer','created_at','updated_at')
                                ->orderBy('id','desc')
                                ->paginate(15);

            return sendSuccessResponse('All FAQs fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function homePage(Request $request): JsonResponse
    {
        try {

            $pageContent = PageHome::first();

            if (!$pageContent) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $default_images = SettingManagement::select('default_course_image','default_blog_image')->first();
            $default_course_image = $default_images->default_course_image;
            $default_blog_image = $default_images->default_blog_image;

            $data['pageContent'] = $pageContent;
            $data['popularTag'] = PopularTag::orderBy('id','desc')->get();
            $data['sectionKeyFeature'] = SectionKeyFeature::first();
            $data['sectionJobAssistanceProgram'] = SectionJobAssistanceProgram::first();
            $data['sectionJobProgramSupport'] = SectionJobProgramSupport::first();
            $data['reviews'] = WebsiteReview::select('id','review','created_at','updated_at')->get();

            $data['trendingCourseList'] = Course::select(
                                                'id',
                                                'category_id',
                                                'course_name',
                                                'duration_value',
                                                'duration_unit',
                                                'demo_video_url',
                                                'course_desc',
                                                'course_overview',
                                                // 'course_content',
                                                DB::raw("COALESCE(courses.course_logo, '$default_course_image') as course_logo"),
                                                'rating',
                                                'total_students_contacted',
                                                'slug',
                                                'mete_title',
                                                'meta_description',
                                                'search_tag',
                                                'meta_keyword',
                                                'seo1',
                                                'seo2',
                                                'seo3',
                                                'feature_field1',
                                                'feature_field2',
                                                'feature_field3',
                                                'created_at',
                                                'updated_at',
                                                )
                                            ->where('status',1)
                                            ->where('is_trending',1)
                                            ->orderBy('id','desc')
                                            ->get();

            $data['popularCourseList'] = Course::select(
                                                'id',
                                                'category_id',
                                                'course_name',
                                                'duration_value',
                                                'duration_unit',
                                                'demo_video_url',
                                                'course_desc',
                                                'course_overview',
                                                // 'course_content',
                                                DB::raw("COALESCE(courses.course_logo, '$default_course_image') as course_logo"),
                                                'rating',
                                                'total_students_contacted',
                                                'slug',
                                                'mete_title',
                                                'meta_description',
                                                'search_tag',
                                                'meta_keyword',
                                                'seo1',
                                                'seo2',
                                                'seo3',
                                                'feature_field1',
                                                'feature_field2',
                                                'feature_field3',
                                                'created_at',
                                                'updated_at',
                                                )
                                            ->where('status',1)
                                            ->where('is_popular',1)
                                            ->orderBy('id','desc')
                                            ->get();

            $data['freeCourseList'] = Course::select(
                                                'id',
                                                'category_id',
                                                'course_name',
                                                'duration_value',
                                                'duration_unit',
                                                'demo_video_url',
                                                'course_desc',
                                                'course_overview',
                                                // 'course_content',
                                                DB::raw("COALESCE(courses.course_logo, '$default_course_image') as course_logo"),
                                                'rating',
                                                'total_students_contacted',
                                                'slug',
                                                'mete_title',
                                                'meta_description',
                                                'search_tag',
                                                'meta_keyword',
                                                'seo1',
                                                'seo2',
                                                'seo3',
                                                'feature_field1',
                                                'feature_field2',
                                                'feature_field3',
                                                'created_at',
                                                'updated_at',
                                                )
                                            ->where('status',1)
                                            ->where('is_free',1)
                                            ->orderBy('id','desc')
                                            ->get();

            $data['blogList'] = $blogs = Blog::select(
                                            'id',
                                            'category_id',
                                            'title',
                                            DB::raw("COALESCE(blogs.image, '$default_blog_image') as image"),
                                            'short_content',
                                            // 'full_content',
                                            'slug',
                                            'mete_title',
                                            'mete_tag',
                                            'meta_description',
                                            'meta_keyword',
                                            'search_tag',
                                            'seo1',
                                            'seo2',
                                            'seo3',
                                            'created_at',
                                            'updated_at'
                                        )
                                        ->where('status',1)
                                        ->orderBy('id','desc')
                                        // ->limit(3)
                                        ->get();


            return sendSuccessResponse('Home page details fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function becomeInstructorPage(Request $request): JsonResponse
    {
        try {

            $pageContent = PageBecomeInstructors::first();

            if (!$pageContent) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $data['pageContent'] = $pageContent;

            return sendSuccessResponse('Become Instructors page details fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function settingsData(Request $request): JsonResponse
    {
        try {

            $settingsData = SettingManagement::select(
                                                    'site_url',
                                                    'title',
                                                    // 'default_course_image',
                                                    // 'default_blog_image',
                                                    // 'default_demo_video_url',
                                                    'phone_no',
                                                    'email',
                                                    'location_1_address',
                                                    'location_2_address',
                                                    'facebook_url',
                                                    'instagram_url',
                                                    'linkedIn_url',
                                                    'youtube_url',
                                                    'twitter_url',
                                                    'header_logo',
                                                    'footer_logo',
                                                    'footer_short_description',
                                                    'footer_copy_right',
                                                    'footer_quick_links',
                                                    'footer_support',
                                                    'footer_disclaimer',
                                                    'footer_category',
                                                    'google_analytics',
                                                    'default_color_theme',
                                                    'current_color_theme'
                                                )
                                                ->first();

            if (!$settingsData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $data['settingsData'] = $settingsData;
            return sendSuccessResponse('Settings data fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
