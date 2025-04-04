<?php

namespace App\Http\Controllers\API\Frontend;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\CourseContact;
use App\Models\SettingManagement;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\Exception;
use Validator;

class CourseController extends Controller
{
    public function listing(Request $request): JsonResponse
    {
        try {

            $category = $request->input('category');  //Filter
            $skill = $request->input('skill');  //search
            $courseName = $request->input('courseName');  //search

            $default_course_image = SettingManagement::value('default_course_image');

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

            $courses = $courses->paginate(15);


            $categoryList = $courses->pluck('categoryDtls')->unique()->values();

            $data = [
                        'courses' => $courses,
                        'categoryList' => $categoryList
                    ];

            return sendSuccessResponse('All courses fetched successfully.', $data);

        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function details(Request $request, $slug): JsonResponse
    {
        try {

            $default_course_image = SettingManagement::value('default_course_image');

            $data = Course::with([
                    'skills',
                    'categoryDtls',
                    'courseCurriculums',
                    'courseTopics',
                    'courseReviews:id,course_id,review,created_at,updated_at',
                    'courseFaqs:id,course_id,question,answer,created_at,updated_at'])
                    ->where('slug', $slug)
                    ->first();

            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $courseData = [
                'id' => $data->id,
                'category_id' => $data->category_id,
                'category_name' => $data->categoryDtls->name,
                'skills' => $data->skills->pluck('id')->toArray(),
                'duration_value' => $data->duration_value,
                'duration_unit' => $data->duration_unit,
                'demo_video_url' => $data->demo_video_url,
                'course_desc' => $data->course_desc,
                // 'overview_img' => $data->overview_img,
                'course_content' => $data->course_content,
                'course_logo' => $data->course_logo ? $data->course_logo : $default_course_image,
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


            // return sendSuccessResponse('Course details fetched successfully.', $data);
            return sendSuccessResponse('Course details fetched successfully.', $courseData);
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
                        ]);

            return sendSuccessResponse('Message sent successfully!', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
