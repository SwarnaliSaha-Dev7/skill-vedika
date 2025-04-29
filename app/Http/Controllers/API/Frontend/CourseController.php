<?php

namespace App\Http\Controllers\API\Frontend;

use Validator;
use App\Models\Course;
use App\Models\Category;
use App\Models\PopularTag;
use Illuminate\Http\Request;
use App\Models\CourseContact;
use App\Models\SettingManagement;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\SectionForCorporate;
use App\Models\SectionLiveFreeDemo;
use App\Http\Controllers\Controller;
use App\Models\PageCourseSearchResult;
use App\Http\Controllers\API\Exception;
use App\Models\SectionJobProgramSupport;
use App\Models\SectionJobAssistanceProgram;
use Illuminate\Support\Facades\Mail;

class CourseController extends Controller
{
    public function listing(Request $request): JsonResponse
    {
        try {

            // $data = Course::
            // where('demo_video_url', null)
            // ->get();

            // $storeInfo = Course::whereNull('demo_video_url')->update(['demo_video_url' => ""]);

            // return sendSuccessResponse('All courses fetched successfully.', $data);
            // //test

            $category = $request->input('category');  //Filter
            $skill = $request->input('skill');  //search
            $courseName = $request->input('courseName');  //search

            // $default_course_image = SettingManagement::value('default_course_image');
            $SettingsData = SettingManagement::first();
            $default_course_image = $SettingsData->default_course_image;
            $default_course_small_icon = $SettingsData->default_course_small_icon;
            // return sendSuccessResponse('All courses fetched successfully.', $default_course_small_icon);

            $courses = Course::with([
                                'skills:id,name',
                                'categoryDtls:id,name',
                                // 'courseCurriculums',
                                // 'courseTopics'
                                ])
                                ->select(
                                    'id',
                                    'category_id',
                                    'course_name',
                                    'duration_value',
                                    'duration_unit',
                                    // 'batch_type',
                                    // 'teaching_mode',
                                    // 'fee',
                                    // 'fee_unit',
                                    'demo_video_url',
                                    'course_desc',
                                    'course_overview',
                                    // 'overview_img',
                                    'course_content',
                                    // 'course_logo',
                                    DB::raw("COALESCE(courses.course_logo, '$default_course_image') as course_logo"),
                                    DB::raw("COALESCE(courses.course_small_icon, '$default_course_small_icon') as course_small_icon"),
                                    'rating',
                                    'total_students_contacted',
                                    'status',
                                    'is_trending',
                                    'is_popular',
                                    'is_free',
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
                                ->orderBy('id','desc');
                                // ->get();
                                // ->paginate(15);

            if (!is_null($category)) {

                $category = json_decode($category, true);
                if(count($category)){
                    $courses->whereIn('category_id', $category);
                }
            }

            if (!is_null($skill)) {
                $courses->whereHas('skills', function ($query) use ($skill) {
                    $query->where('name', 'LIKE', "%$skill%");
                });
            }

            if (!is_null($courseName)) {
                $courses->where('course_name', 'LIKE', "%$courseName%");
            }

            // $courses = $courses->paginate(15);
            $courses = $courses->get();

            // // $categoryList = $courses->pluck('categoryDtls')->unique()->values();
            // $categoryList = $courses->pluck('categoryDtls');
            // $categoryList = $categoryList->groupBy('id')->map(function ($items, $key) {
            //     return [
            //         'id' => $key,
            //         'name' => $items->first()->name,
            //         'count' => $items->count()
            //     ];
            // })->values();

            $categoryList = Category::select('id','name')
            ->whereHas('courses', function ($query) {
                $query->where('status', 1);
            })
            ->withCount(['courses as count' => function ($query) {
                $query->where('status', 1);
            }])
            ->get();


            $data = [
                        'courses' => $courses,
                        'categoryList' => $categoryList,
                        'pageContent' =>  PageCourseSearchResult::first(),
                        'popularTag' => PopularTag::orderBy('id','desc')->get(),
                        'SectionLiveFreeDemo' => SectionLiveFreeDemo::first(),
                    ];

            return sendSuccessResponse('All courses fetched successfully.', $data);

        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function details(Request $request, $slug): JsonResponse
    {
        try {

            $SettingsData = SettingManagement::first();
            $default_course_image = $SettingsData->default_course_image;
            $default_course_small_icon = $SettingsData->default_course_small_icon;
            $default_demo_video_url = $SettingsData->default_demo_video_url;

            // $default_course_image = SettingManagement::value('default_course_image');

            $data = Course::with([
                    'skills',
                    'categoryDtls',
                    'courseCurriculums',
                    'courseTopics',
                    'courseReviews:id,course_id,review,created_at,updated_at',
                    'courseFaqs:id,course_id,question,answer,created_at,updated_at'])
                    ->where('slug', $slug)
                    ->first();

            // return sendSuccessResponse('Course details fetched successfully.', $data);


            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $courseData = [
                'id' => $data->id,
                'course_name' => $data->course_name,
                'category_id' => $data->category_id,
                'category_name' => $data->categoryDtls->name,
                // 'skills' => $data->skills->pluck('id')->toArray(),
                'skills' => $data->skills->pluck('name')->toArray(),
                'duration_value' => $data->duration_value,
                'duration_unit' => $data->duration_unit,
                'demo_video_url' => $data->demo_video_url ? $data->demo_video_url : $default_demo_video_url,
                'course_desc' => $data->course_desc,
                'course_overview' => $data->course_overview,
                // 'overview_img' => $data->overview_img,
                'course_content' => $data->course_content,
                'course_logo' => $data->course_logo ? $data->course_logo : $default_course_image,
                'course_small_icon' => $data->course_small_icon ? $data->course_small_icon : $default_course_small_icon,
                'rating' => $data->rating,
                'total_students_contacted' => $data->total_students_contacted,
                'status' => $data->status,
                'is_trending' => $data->is_trending,
                'is_popular' => $data->is_popular,
                'is_free' => $data->is_free,
                // 'featured' => $data->featured,
                'slug' => $data->slug,
                'mete_title' => $data->mete_title,
                'meta_description' => $data->meta_description,
                'search_tag' => $data->search_tag,
                'meta_keyword' => $data->meta_keyword,
                'seo1' => $data->seo1,
                'seo2' => $data->seo2,
                'seo3' => $data->seo3,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
                'course_curriculums' => $data->courseCurriculums,
                'course_topics' => $data->courseTopics,
                'course_reviews' => $data->courseReviews,
                'courseFaqs' => $data->courseFaqs,
            ];

            $data = null;
            $data['courseData'] = $courseData;
            $data['sectionForCorporate'] = SectionForCorporate::first();
            $data['sectionJobAssistanceProgram'] = SectionJobAssistanceProgram::first();
            $data['sectionJobProgramSupport'] = SectionJobProgramSupport::first();


            // return sendSuccessResponse('Course details fetched successfully.', $data);
            return sendSuccessResponse('Course details fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function courseContact(Request $request): JsonResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'course_id' => 'required',
                'student_name' => 'required',
                'student_email' => 'required',
                'phone' => 'required',
                'is_terms_and_condition_checked_by_student' => 'required',
            ]);

            if ($validator->fails()) {
                return sendErrorResponse('Validation Error.', $validator->errors(), 400);
            }

            $storeInfo = CourseContact::create([
                            'course_id' => $request->course_id,
                            'student_name' => $request->student_name,
                            'student_email' => $request->student_email,
                            'calling_code' => $request->calling_code,
                            'phone' => $request->phone,
                            'message' => $request->message,
                            'is_terms_and_condition_checked_by_student' => $request->is_terms_and_condition_checked_by_student,
                        ]);

            // $courseDtls = Course::find($request->course_id);

            $data = [
                // "course_name" => $courseDtls->course_name,
                'student_name' => $request->student_name,
                'student_email' => $request->student_email,
                'student_phone' => "+".$request->calling_code." ".$request->phone,
                "date" => \Carbon\Carbon::now()->toDateString(),
            ];

            // Send email to Admin
            $adminEmail = env('ADMIN_MAIL');
            Mail::send('email.frontend.studentLeadGenerationNotification', $data, function ($message) use ($adminEmail) {
                $message->to($adminEmail) // Use the recipient's email
                    ->subject('Student Lead Generation Alert on Skill Vedika');
                $message->from(env('MAIL_FROM_ADDRESS'), "Skill Vedika");
            });

            return sendSuccessResponse('Message sent successfully!', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
