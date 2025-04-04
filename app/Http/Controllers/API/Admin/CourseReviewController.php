<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\CourseReview;
use App\Http\Controllers\API\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Validator;

class CourseReviewController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'course_id' => 'required',
                'review' => 'required',
            ]);

            if ($validator->fails()) {
                return sendErrorResponse('Validation Error.', $validator->errors(), 400);
            }

            $storeInfo = CourseReview::create([
                            'course_id' => $request->course_id,
                            'review' => $request->review,
                        ]);

            return sendSuccessResponse('Review inserted successfully.', '');
        } catch (\Throwable $th) {
            // Log::error('Review inserted error: ' . $th->getMessage());
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function listing(Request $request): JsonResponse
    {
        try {

            $data = CourseReview::with('course:id,course_name')
                                ->select('id','course_id','review','created_at','updated_at')
                                ->orderBy('id','desc')
                                ->paginate(15);

            return sendSuccessResponse('All reviews fetched successfully.', $data);
        } catch (\Throwable $th) {
            // Log::error('All reviews fetched error: ' . $th->getMessage());
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function updatedDataFetch(Request $request, $id): JsonResponse
    {
        try {

            $data = CourseReview::select('id','course_id','review','created_at','updated_at')
                                ->find($id);

            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }
            return sendSuccessResponse('Review data fetched successfully.', $data);
        } catch (\Throwable $th) {
            // Log::error('Review data fetched error: ' . $th->getMessage());
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'review' => 'required',
            ]);

            if ($validator->fails()) {
                return sendErrorResponse('Validation Error.', $validator->errors(), 400);
            }

            $checkData = CourseReview::find($id);

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $storeInfo = CourseReview::where('id', $id)
                                        ->update(['review' => $request->review,]);

            return sendSuccessResponse('Review updated successfully.', '');
        } catch (\Throwable $th) {
            // Log::error('Review updated fetched error: ' . $th->getMessage());
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function destroy(Request $request, $id): JsonResponse
    {
        try {

            $checkData = CourseReview::find($id);

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $checkData->delete();

            return sendSuccessResponse('Review deleted successfully.', '');
        } catch (\Throwable $th) {
            // Log::error('Review deleted error: ' . $th->getMessage());
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
