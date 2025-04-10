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
            $now = \Carbon\Carbon::now();
            $faqs = array_map(function ($faq) use ($now, $request){
                return [
                    'course_id' => $request->course_id,
                    'question' => $faq->question,
                    'answer' => $faq->answer,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

            }, $faqs);

            CourseFaq::insert($faqs);

            return sendSuccessResponse('FAQs inserted successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function listing(Request $request): JsonResponse
    {
        try {

            $data = CourseFaq::with('course:id,course_name')
                                // ->select('id','course_id','question','answer','created_at','updated_at')
                                ->select(
                                    'course_id',
                                    DB::raw('GROUP_CONCAT(CONCAT("Q:", question, ", A:", answer)  SEPARATOR " || ") as faqs')
                                    )
                                ->groupBy('course_id')
                                // ->orderBy('id','desc')
                                ->paginate(15);

            return sendSuccessResponse('All FAQs fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function updatedDataFetch(Request $request, $id): JsonResponse
    {
        try {

            $data = CourseFaq::select('id','course_id','question','answer','created_at','updated_at')
                                ->find($id);

            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }
            return sendSuccessResponse('FAQ data fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'question' => 'required',
                'answer' => 'required',
            ]);

            if ($validator->fails()) {
                return sendErrorResponse('Validation Error.', $validator->errors(), 400);
            }

            $checkData = CourseFaq::find($id);

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $storeInfo = CourseFaq::where('id', $id)
                                        ->update([
                                            'question' => $request->question,
                                            'answer' => $request->answer,
                                        ]);

            return sendSuccessResponse('FAQ updated successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function destroy(Request $request, $id): JsonResponse
    {
        try {

            $checkData = CourseFaq::find($id);

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $checkData->delete();

            return sendSuccessResponse('FAQ deleted successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
