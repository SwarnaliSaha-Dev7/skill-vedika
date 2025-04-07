<?php

namespace App\Http\Controllers\API\Frontend;

use Validator;
use App\Models\Blog;
use App\Models\Course;
use App\Models\PageHome;
use App\Models\WebsiteFaq;
use App\Models\PageAboutUs;
use Illuminate\Http\Request;
use App\Models\PageContactUs;
use App\Models\WebsiteReview;
use App\Models\SectionKeyFeature;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\PageTermsAndCondition;
use App\Http\Controllers\API\Exception;
use App\Models\SectionJobProgramSupport;
use App\Models\SectionJobAssistanceProgram;

class CMSController extends Controller
{

    public function aboutUsPage(Request $request): JsonResponse
    {
        try {

            $data = PageAboutUs::first();

            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }
            return sendSuccessResponse('About Us page details fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function termsAndConditionPage(Request $request): JsonResponse
    {
        try {

            $data = PageTermsAndCondition::first();

            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }
            return sendSuccessResponse('Terms and Conditions page details fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function contactUsPage(Request $request): JsonResponse
    {
        try {

            $data = PageContactUs::first();

            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }
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

            $PageHomeData = PageHome::first();

            if (!$PageHomeData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $data['PageHomeData'] = $PageHomeData;
            $data['sectionKeyFeature'] = SectionKeyFeature::first();
            $data['sectionJobAssistanceProgram'] = SectionJobAssistanceProgram::first();
            $data['sectionJobProgramSupport'] = SectionJobProgramSupport::first();
            $data['reviews'] = WebsiteReview::select('id','review','created_at','updated_at')->get();

            // $data['trendingCourseList'] = Course::select(
            //                                         'id',
            //                                         'course_name',
            //                                         'duration_value',
            //                                         'duration_unit',
            //                                         'image',
            //                                         'short_content',
            //                                         'slug',
            //                                         'mete_title',
            //                                         'mete_tag',
            //                                         'meta_description',
            //                                         'meta_keyword',
            //                                         'search_tag',
            //                                         'seo1',
            //                                         'seo2',
            //                                         'seo3',
            //                                         'created_at',
            //                                         'updated_at'
            //                                     )
            //                                     ->where('is_trending', 1)
            //                                     ->orderBy('id','desc')
            //                                     ->get();

            $data['blogList'] = $blogs = Blog::select(
                                            'id',
                                            // 'category_id',
                                            'title',
                                            'image',
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
                                        ->orderBy('id','desc')
                                        // ->limit(3)
                                        ->get();


            return sendSuccessResponse('Home page details fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
