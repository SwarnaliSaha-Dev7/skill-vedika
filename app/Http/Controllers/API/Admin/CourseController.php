<?php

namespace App\Http\Controllers\API\Admin;

use Validator;
use App\Models\Course;
use App\Models\CourseFaq;
use App\Models\CourseTopic;
use Illuminate\Support\Str;
use App\Models\CourseReview;
use App\Models\CoursesSkill;
use Illuminate\Http\Request;
use App\Models\CourseContact;
use App\Models\CourseCurriculum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\API\Exception;

class CourseController extends Controller
{
    function generateSlug($title, $table, $id)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;

        // Ensure the slug is unique in the table
        // $count = 1;
        // while (DB::table($table)->where('slug', $slug)->exists()) {
        //     $slug = $originalSlug . '-' . $id;
        //     $count++;
        // }

        // if($table::where('slug', $slug)->exists()){
        if(Course::where('slug', $slug)->exists()){
            $count = $id; //$id is generated random no
            $slug = $originalSlug . '-' . $count;

            // while (Course::where('slug', $slug)->exists()) {
            //     $count++;
            //     $slug = $originalSlug . '-' . $count;
            // }
        }

        return $slug;
    }

    public function delete_file($path)
    {
        //$file_path = public_path('path/to/your/file.txt');
        $file_path = public_path($path);
        if (File::exists($file_path)) {
            File::delete($file_path);
            // echo 'File deleted successfully.';
        } else {
            // echo 'File does not exist.';
        }
    }

    public function add(Request $request): JsonResponse
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'category_id' => 'required|integer',
                    'skills' => 'required',
                    'course_name' => 'required',
                    // 'duration_value' => 'required',
                    // 'duration_unit' => 'required',
                    // 'default img'
                ]
            );

            if ($validator->fails()) {
                return sendErrorResponse('Validation Error.', $validator->errors(), 400);
            }

            // return sendSuccessResponse('Course added successfully.', $request->all());

            // return $request->all();
            // return $request->curriculum_image;
            // return 423423;

            // Save new file
            $path = public_path('uploads/course');
            // if (!file_exists($path)) {
            //     mkdir($path, 0777, true);
            // }
            //save course_logo
            $fileName = null;
            $courseLogoFilePath = null;
            if ($request->hasFile('course_logo')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('course_logo')->getClientOriginalName();
                $request->course_logo->move($path, $fileName);
                $courseLogoFilePath = "uploads/course/" . $fileName;
            }

            // //save overview_img
            // $fileName = null;
            // $courseOverviewImgFilePath = null;
            // if ($request->hasFile('overview_img')) {
            //     $fileName = time() . rand(1000, 9999) . "_" . $request->file('overview_img')->getClientOriginalName();
            //     $request->overview_img->move($path, $fileName);
            //     $courseOverviewImgFilePath = "uploads/course/" . $fileName;
            // }

            $randNo = rand(1000, 9999);
            $slug = $this->generateSlug($request->course_name, 'Course', $randNo);

            $insertedData = [
                'category_id' => $request->category_id,
                // 'skill_id' => $request->skill,
                'course_name' => $request->course_name,
                'duration_value' => $request->duration_value,
                'duration_unit' => $request->duration_unit,
                'demo_video_url' => $request->demo_video_url,
                'course_desc' => $request->course_desc,
                'course_overview' => $request->course_overview,
                // 'overview_img' => $courseOverviewImgFilePath,
                'course_content' => $request->course_content,
                'course_logo' => $courseLogoFilePath,
                'rating' => $request->rating,
                'total_students_contacted' => $request->total_students_contacted,
                'status' => $request->status,
                'is_trending' => $request->is_trending,
                'is_popular' => $request->is_popular,
                'is_free' => $request->is_free,
                'mete_title' => $request->mete_title,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword,
                'search_tag' => $request->search_tag,
                'seo1' => $request->seo1,
                'seo2' => $request->seo2,
                'seo3' => $request->seo3,
                'slug' => $slug,
            ];

            $storeInfo = Course::create($insertedData);
            $course_id = $storeInfo->id;

            //store skills
            if ($request->skills && count(json_decode($request->skills)) > 0) {
                $skillArr = json_decode($request->skills);

                $insertedData = [];
                foreach ($skillArr as $x) {
                    $insertedData[] = [
                        'course_id' => $course_id,
                        'skill_id' => $x,
                        'created_at' => \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now(),
                    ];
                }
                CoursesSkill::insert($insertedData);
            }

            // $user_details = DB::table('users')->where('id', $request->user_id)->first();
            // if ($user_details) {
                //     $email = $user_details->email;
                //     $name = $user_details->f_name;

                //     $data = array("email" => $email, "name" => $name, 'course_name' => $request->course_name);
                //     // Send email
                //     Mail::send('email.courseListing', $data, function ($message) use ($email) {
                //         $message->to($email) // Use the recipient's email
                //             ->subject('Your Course Listing is Under Review on FindMyGuru');
                //         $message->from(env('MAIL_FROM_ADDRESS'), "Find My Guru");
                //     });

                //     $date = \Carbon\Carbon::now();
                //     $adminData = array("name" => $name, "course_title" => $request->course_name, "course_description" => $request->course_content, "course_fee" => $request->fee, "duration" => $request->duration_value, 'duration_unit' => $request->duration_unit, "teaching_mode" => $request->teaching_mode, "date_added" => $date);
                //     $adminEmail = env('ADMIN_MAIL');
                //     // Send email
                //     Mail::send('email.admin.courseAdditionAlert', $adminData, function ($message) use ($adminEmail) {
                //         $message->to($adminEmail) // Use the recipient's email
                //             ->subject('New Course Added by Tutor on FindMyGuru');
                //         $message->from(env('MAIL_FROM_ADDRESS'), "Find My Guru");
                //     });
            // }


            //store course curriculum
            $course_curriculum = json_decode($request->course_curriculum);
            $request->curriculum_image = json_decode($request->curriculum_image);

            // $course_curriculum = $request->course_curriculum;
            // $request->curriculum_image = json_encode($request->curriculum_image);
            // $request->curriculum_image = json_decode($request->curriculum_image);
            // return sendSuccessResponse('Course added successfully new12.', $request->curriculum_image);


            // $images = json_decode($request->curriculum_image, true);
            // $course_curriculum = $request->course_curriculum;
            // $images = $request->curriculum_image;
            // foreach ($request->file('curriculum_image') as $index => $image) {

            //     // $path = $image->store('public/curriculum_images');
            //     $path = $image->store('curriculum_images');
            //     // return sendSuccessResponse('Course added successfully332.', $path);

            //     // // Optional: save path with the related curriculum title
            //     // Curriculum::create([
            //     //     'title' => $curriculums[$index] ?? 'Untitled',
            //     //     'image_path' => $path,
            //     // ]);
            // }
            // $carImg = json_decode($request->curriculum_image, true);
            // return sendSuccessResponse('Course add successfully636.', $request->curriculum_image);

            $course_curriculum_data = [];
            foreach($course_curriculum as $key=>$record){
                $curriculum_data['course_id'] = $course_id;
                // $curriculum_data['curriculum'] = $record->curriculum;
                $curriculum_data['curriculum'] = $record;
                $curriculum_data['created_at'] = \Carbon\Carbon::now();
                $curriculum_data['updated_at'] = \Carbon\Carbon::now();

                // $file = $request->file('curriculum_image.' . 0);
                // $dtls["mimeType"] = $file->getMimeType();
                // $dtls["size"] = $file->getSize();
                // return sendSuccessResponse('Course add successfully636.', $dtls);

                //upload image
                $fileName = null;
                $filePath = null;
                if ($request->hasFile('curriculum_image.' . $key)) {
                    $file = $request->file('curriculum_image.' . $key);
                    $fileName = time() . rand(1000, 9999) . '_' . $file->getClientOriginalName();
                    $file->move($path, $fileName);
                    $filePath = "uploads/course/" . $fileName;
                }
                // else{
                //     $filePath = "doc_not_found";
                // }
                $curriculum_data['image'] = $filePath;


                $course_curriculum_data[] = $curriculum_data;
            }

            CourseCurriculum::insert($course_curriculum_data);

            //store course topics
            $course_topics = json_decode($request->course_topics);
            $course_topics_data = [];
            foreach($course_topics as $record){
                $topic_data['course_id'] = $course_id;
                $topic_data['label'] = $record->label;
                $topic_data['desc'] = $record->desc;
                $topic_data['created_at'] = \Carbon\Carbon::now();
                $topic_data['updated_at'] = \Carbon\Carbon::now();

                $course_topics_data[] = $topic_data;
            }

            CourseTopic::insert($course_topics_data);


            return sendSuccessResponse('Course added successfully.', $course_id);
        } catch (\Throwable $th) {
            // Log::error('Course added error: ' . $th->getMessage());
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function listing(Request $request): JsonResponse
    {
        try {

            // $pageNumber = request()->input('page', 1); // Get 'page' parameter from the request, default to 1
            // $perPage = 15;

            $courses = Course::with([
                                'skills',
                                'categoryDtls',
                                // 'courseCurriculums',
                                // 'courseTopics'
                                ])
                                ->orderBy('id','desc')
                                // ->get();
                                ->paginate(15);
                                // ->paginate($perPage, ['*'], 'page', $pageNumber);

            // return sendSuccessResponse('All courses fetched successfully.', $courses);

            // $courses = $data->data->map(function ($course) {
            // $courses = $courses->getCollection()->map(function ($course) {

            $courses->getCollection()->transform(function ($course) {
                return [
                    'id' => $course->id,
                    'course_name' => $course->course_name,
                    'category' => $course->categoryDtls->name,
                    'skills' => $course->skills->pluck('name')->toArray(),
                    'duration_value' => $course->duration_value,
                    'duration_unit' => $course->duration_unit,
                    'demo_video_url' => $course->demo_video_url,
                    'course_desc' => $course->course_desc,
                    // 'overview_img' => $course->overview_img,
                    'course_content' => $course->course_content,
                    'course_logo' => $course->course_logo,
                    'rating' => $course->rating,
                    'total_students_contacted' => $course->total_students_contacted,
                    'status' => $course->status,
                    'is_trending' => $course->is_trending,
                    'is_popular' => $course->is_popular,
                    'is_free' => $course->is_free,
                    // 'featured' => $course->featured,
                    'slug' => $course->slug,
                    'mete_title' => $course->mete_title,
                    'meta_description' => $course->meta_description,
                    'search_tag' => $course->search_tag,
                    'meta_keyword' => $course->meta_keyword,
                    'seo1' => $course->seo1,
                    'seo2' => $course->seo2,
                    'seo3' => $course->seo3,
                    'created_at' => $course->created_at,
                    'updated_at' => $course->updated_at,
                    // 'course_curriculums' => $course->courseCurriculums,
                    // 'course_topics' => $course->courseTopics,
                ];
            });

            return sendSuccessResponse('All courses fetched successfully.', $courses);

        } catch (\Throwable $th) {
            // Log::error('All courses fetched error: ' . $th->getMessage());
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function updatedDataFetch(Request $request, $id): JsonResponse
    {
        try {

            $data = Course::with(['skills', 'categoryDtls','courseCurriculums','courseTopics'])
                    ->find($id);

            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $courseData = [
                'id' => $data->id,
                'category_id' => $data->category_id,
                'course_name' => $data->course_name,
                // 'category' => $data->categoryDtls->name,
                'skills' => $data->skills->pluck('id')->toArray(),
                'duration_value' => $data->duration_value,
                'duration_unit' => $data->duration_unit,
                'demo_video_url' => $data->demo_video_url,
                'course_desc' => $data->course_desc,
                'course_overview' => $data->course_overview,
                // 'overview_img' => $data->overview_img,
                'course_content' => $data->course_content,
                'course_logo' => $data->course_logo,
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
            ];


            // return sendSuccessResponse('Course details fetched successfully.', $data);
            return sendSuccessResponse('Course details fetched successfully.', $courseData);
        } catch (\Throwable $th) {
            // Log::error('Course details fetched error: ' . $th->getMessage());
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            //dd($request->all());

            $validator = Validator::make($request->all(), [
                'category_id' => 'required|integer',
                'skills' => 'required',
                'course_name' => 'required',
            ]);

            if ($validator->fails()) {
                return sendErrorResponse('Validation Error.', $validator->errors(), 400);
            }

            // return sendSuccessResponse('Course updated successfully636.', $request->all());

            $courseData = Course::find($id);

            if (!$courseData) {
                return sendErrorResponse('Data not found.', '', 404);
            }
            // return sendSuccessResponse('Category details updated successfully.', $courseData);

            $slug = $courseData->slug;
            if ($courseData->course_name != $request->course_name) {
                $randNo = rand(1000, 9999);
                $slug = $this->generateSlug($request->course_name, 'Course', $randNo);
            }

            // Save new file
            $path = public_path('uploads/course');
            // if (!file_exists($path)) {
            //     mkdir($path, 0777, true);
            // }

            $fileName = null;
            $courseLogoFilePath = null;
            if ($request->hasFile('course_logo')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('course_logo')->getClientOriginalName();
                $request->course_logo->move($path, $fileName);
                $courseLogoFilePath = "uploads/course/" . $fileName;

                if ($courseData->course_logo) {
                    $this->delete_file($courseData->course_logo);
                }
            } else {
                if($request->course_logo){
                    $courseLogoFilePath = $courseData->course_logo;
                }
                // else{
                //     $courseLogoFilePath = null;
                // }
            }

            $updatedData = [
                'category_id' => $request->category_id,
                // 'skill_id' => $request->skills,
                'course_name' => $request->course_name,
                'duration_value' => $request->duration_value,
                'duration_unit' => $request->duration_unit,
                'demo_video_url' => $request->demo_video_url,
                'course_desc' => $request->course_desc,
                'course_overview' => $request->course_overview,
                // 'overview_img' => $courseOverviewImgFilePath,
                'course_content' => $request->course_content,
                'course_logo' => $courseLogoFilePath,
                'rating' =>  $request->rating,
                'total_students_contacted' =>  $request->total_students_contacted,
                'status' => $request->status,
                'is_trending' => $request->is_trending,
                'is_popular' => $request->is_popular,
                'is_free' => $request->is_free,
                'mete_title' => $request->mete_title,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword,
                'search_tag' => $request->search_tag,
                'seo1' => $request->seo1,
                'seo2' => $request->seo2,
                'seo3' => $request->seo3,
                'slug' => $slug,
            ];

            $storeInfo = Course::where('id', $id)->update($updatedData);

            if ($request->skills && count(json_decode($request->skills)) > 0) {
                CoursesSkill::where('course_id', $id)->delete();
                $skillArr = json_decode($request->skills);

                $insertedData = [];
                foreach ($skillArr as $x) {
                    $insertedData[] = [
                        'course_id' => $id,
                        'skill_id' => $x,
                        'created_at' => \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now(),
                    ];
                }
                CoursesSkill::insert($insertedData);
            }


            $prevCurriculumImgList = CourseCurriculum::where('course_id', $id)
                                                        ->where('image', '!=', null)
                                                        ->get()
                                                        ->pluck('image')
                                                        ->toArray();

            if ($request->course_curriculum && count(json_decode($request->course_curriculum)) > 0) {
            // if ($request->course_curriculum && count($request->course_curriculum) > 0) {
                CourseCurriculum::where('course_id', $id)->delete();
                $course_curriculum = json_decode($request->course_curriculum);
                // $course_curriculum = $request->course_curriculum;
                $request->curriculum_image = json_decode($request->curriculum_image);
                $course_curriculum_data = [];

                foreach($course_curriculum as $key=>$record){

                    $curriculum_data['course_id'] = $id;
                    // $curriculum_data['curriculum'] = $record->curriculum;
                    $curriculum_data['curriculum'] = $record;
                    $curriculum_data['created_at'] = \Carbon\Carbon::now();
                    $curriculum_data['updated_at'] = \Carbon\Carbon::now();

                    //upload image
                    $fileName = null;
                    $filePath = null;
                    // $tempFile = $record->curriculum_image;
                    if ($request->hasFile('curriculum_image.' . $key)) {
                        $file = $request->file('curriculum_image.' . $key);
                        $fileName = time() . rand(1000, 9999) . '_' . $file->getClientOriginalName();
                        $file->move($path, $fileName);
                        $filePath = "uploads/course/" . $fileName;
                    }
                    else{
                        if($request->input('curriculum_image.' . $key)){
                            //has old file path
                            $filePath = $request->input('curriculum_image.' . $key);
                        }
                    }
                    $curriculum_data['image'] = $filePath;


                    $course_curriculum_data[] = $curriculum_data;
                }

                CourseCurriculum::insert($course_curriculum_data);
            }

            $currentCurriculumImgList = CourseCurriculum::where('course_id', $id)
                                                        ->where('image', '!=', null)
                                                        ->get()
                                                        ->pluck('image')
                                                        ->toArray();

            // $deleteImg = [];
            foreach ($prevCurriculumImgList as $img) {
                if(!in_array($img, $currentCurriculumImgList)){
                    // $deleteImg[] = $img;
                    $this->delete_file($img);
                }
            }

            // $data['prevCurriculumImgList'] = $prevCurriculumImgList;
            // $data['currentCurriculumImgList'] = $currentCurriculumImgList;
            // $data['deleteImg'] = $deleteImg;
            // return sendSuccessResponse('Course updated successfully.', $data);


            if ($request->course_topics && count(json_decode($request->course_topics)) > 0) {
                CourseTopic::where('course_id', $id)->delete();
                $course_topics = json_decode($request->course_topics);
                $course_topics_data = [];

                foreach($course_topics as $record){
                    $topic_data['course_id'] = $id;
                    $topic_data['label'] = $record->label;
                    $topic_data['desc'] = $record->desc;
                    $topic_data['created_at'] = \Carbon\Carbon::now();
                    $topic_data['updated_at'] = \Carbon\Carbon::now();

                    $course_topics_data[] = $topic_data;
                }

                CourseTopic::insert($course_topics_data);
            }

            return sendSuccessResponse('Course updated successfully.', '');
        } catch (\Throwable $th) {
            // Log::error('Token generation error: ' . $th->getMessage());
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function destroy(Request $request, $id): JsonResponse
    {
        try {

            $checkData = Course::find($id);

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            if ($checkData->course_logo) {
                $this->delete_file($checkData->course_logo);
            }

            //delete skills
            CoursesSkill::where('course_id', $id)->delete();


            //delete curriculums images
            $curriculumImages = CourseCurriculum::where('course_id', $id)->get()->pluck('image');
            foreach ($curriculumImages as $imagePath) {
                $this->delete_file($imagePath);
            }

            //delete curriculums
            CourseCurriculum::where('course_id', $id)->delete();

            //delete topics
            CourseTopic::where('course_id', $id)->delete();

            //delete reviews
            CourseReview::where('course_id', $id)->delete();

            //delete FAQs
            CourseFaq::where('course_id', $id)->delete();

            //delete course
            $checkData->delete();

            return sendSuccessResponse('Course details deleted successfully.', '');
        } catch (\Throwable $th) {
            // Log::error('Course deleted error: ' . $th->getMessage());
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function studentContactList(Request $request): JsonResponse
    {
        try {

            $list = CourseContact::with([
                                        'courseDtls:id,course_name,category_id',
                                        'courseDtls.categoryDtls:id,name',
                                        'courseDtls.skills:name'
                                        ])
                                    ->orderBy('id','desc')
                                    ->paginate(15);

            return sendSuccessResponse('All contacts fetched successfully.', $list);

        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function studentContactView(Request $request, $id): JsonResponse
    {
        try {

            $data = CourseContact::with([
                                        'courseDtls:id,course_name,category_id',
                                        'courseDtls.categoryDtls:id,name',
                                        'courseDtls.skills:name'
                                    ])
                                    ->find($id);

            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            return sendSuccessResponse('Contact details fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function studentContactDestroy(Request $request, $id): JsonResponse
    {
        try {

            $checkData = CourseContact::find($id);

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $checkData->delete();

            return sendSuccessResponse('Contact details deleted successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
