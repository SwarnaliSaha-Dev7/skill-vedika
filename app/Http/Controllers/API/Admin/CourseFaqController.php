<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CourseFaq;
use App\Http\Controllers\API\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Validator;

class CourseFaqController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'course_id' => 'required',
                'faqs' => 'required',
                // 'question' => 'required',
                // 'answer' => 'required',
            ]);

            if ($validator->fails()) {
                return sendErrorResponse('Validation Error.', $validator->errors(), 400);
            }

            // $storeInfo = CourseFaq::create([
            //                 'course_id' => $request->course_id,
            //                 'question' => $request->question,
            //                 'answer' => $request->answer,
            //             ]);

            //store faqs
            $faqs = json_decode($request->faqs);
            $course_id_set = json_decode($request->course_id);
            $faqsData = [];
            $now = \Carbon\Carbon::now();
            // $faqs = array_map(function ($faq) use ($now, $request){
            //     return [
            //         'course_id' => $request->course_id,
            //         'question' => $faq->question,
            //         'answer' => $faq->answer,
            //         'created_at' => $now,
            //         'updated_at' => $now,
            //     ];

            // }, $faqs);

            foreach ($course_id_set as $key => $course_id) {
                foreach ($faqs as $key => $faq) {
                    $faqsData[] = [
                                        'course_id' => $course_id,
                                        'question' => $faq->question,
                                        'answer' => $faq->answer,
                                        'created_at' => $now,
                                        'updated_at' => $now,
                                    ];
                }
            }

            CourseFaq::insert($faqsData);

            return sendSuccessResponse('FAQs inserted successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function listing(Request $request): JsonResponse
    {
        try {

            $data = CourseFaq::with('course:id,course_name')
                                ->select(
                                    'course_id',
                                    DB::raw('GROUP_CONCAT(CONCAT("Q:", question, ", A:", answer)  SEPARATOR " || ") as faqs'),
                                    DB::raw('COUNT(*) as total_faqs')
                                    )
                                ->groupBy('course_id')
                                // ->orderBy('id','desc')
                                ->paginate(15);

            return sendSuccessResponse('All FAQs fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function updatedDataFetch(Request $request, $course_id): JsonResponse
    {
        try {

            $faqs = CourseFaq::with('course:id,course_name')
                                ->where('course_id', $course_id)
                                ->get();
            // select('id','course_id','question','answer','created_at','updated_at')
                                // ->find($id);

            if (!count($faqs)) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $data['course_id'] = $faqs->first()->course_id;
            $data['course_name'] = $faqs->first()->course->course_name;
            $data['faqs'] = $faqs->select('question','answer');

            return sendSuccessResponse('FAQ data fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function update(Request $request, $course_id): JsonResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'faqs' => 'required'
            ]);

            if ($validator->fails()) {
                return sendErrorResponse('Validation Error.', $validator->errors(), 400);
            }

            $checkData = CourseFaq::where('course_id', $course_id)
                                    ->get();

            if (!count($checkData)) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            //delete prev faqs
            CourseFaq::where('course_id', $course_id)->delete();

            // $storeInfo = CourseFaq::where('id', $id)
            //                             ->update([
            //                                 'question' => $request->question,
            //                                 'answer' => $request->answer,
            //                             ]);

            //store reviews
            $faqs = json_decode($request->faqs);
            $now = \Carbon\Carbon::now();
            $faqs = array_map(function ($faq) use ($now, $course_id){
                return [
                    'course_id' => $course_id,
                    'question' => $faq->question,
                    'answer' => $faq->answer,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

            }, $faqs);

            CourseFaq::insert($faqs);

            return sendSuccessResponse('FAQs updated successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function destroy(Request $request, $course_id): JsonResponse
    {
        try {

            $checkData = CourseFaq::where('course_id', $course_id)->get();

            if (!count($checkData)) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            CourseFaq::where('course_id', $course_id)->delete();

            return sendSuccessResponse('FAQs deleted successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
