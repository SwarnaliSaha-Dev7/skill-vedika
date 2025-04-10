<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\CourseReview;
use App\Http\Controllers\API\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
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

            // $storeInfo = CourseReview::create([
            //                 'course_id' => $request->course_id,
            //                 'review' => $request->review,
            //             ]);

            //store reviews
            $reviews = json_decode($request->review);
            $now = \Carbon\Carbon::now();
            $reviews = array_map(function ($text) use ($now, $request){
                return [
                    'course_id' => $request->course_id,
                    'review' => $text,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

            }, $reviews);

            CourseReview::insert($reviews);

            return sendSuccessResponse('Reviews inserted successfully.', '');
        } catch (\Throwable $th) {
            // Log::error('Review inserted error: ' . $th->getMessage());
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function listing(Request $request): JsonResponse
    {
        try {

            $data = CourseReview::with('course:id,course_name')
                                // ->select('id','course_id','review','created_at','updated_at')
                                ->select(
                                    'course_id',
                                    DB::raw('GROUP_CONCAT(review SEPARATOR " || ") as reviews'))
                                // ->orderBy('id','desc')
                                ->groupBy('course_id')
                                ->paginate(15);

            return sendSuccessResponse('All reviews fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function updatedDataFetch(Request $request, $course_id): JsonResponse
    {
        try {

            // $data = CourseReview::select('id','course_id','review','created_at','updated_at')
            //                     ->find($id);

            $reviews = CourseReview::with('course:id,course_name')
                                ->where('course_id', $course_id)
                                ->get();

            if (!count($reviews)) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $data['course_id'] = $reviews->first()->course_id;
            $data['course_name'] = $reviews->first()->course->course_name;
            $data['reviews'] = $reviews->pluck('review');

            return sendSuccessResponse('Review data fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function update(Request $request, $course_id): JsonResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'review' => 'required',
            ]);

            if ($validator->fails()) {
                return sendErrorResponse('Validation Error.', $validator->errors(), 400);
            }

            $checkData = CourseReview::where('course_id', $course_id)->get();

            if (!count($checkData)) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            //delete prev reviews
            CourseReview::where('course_id', $course_id)->delete();

            //store reviews
            $reviews = json_decode($request->review);
            $now = \Carbon\Carbon::now();
            $reviews = array_map(function ($text) use ($now, $course_id){
                return [
                    'course_id' => $course_id,
                    'review' => $text,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

            }, $reviews);

            CourseReview::insert($reviews);

            // $storeInfo = CourseReview::where('id', $id)
            //                             ->update(['review' => $request->review,]);

            return sendSuccessResponse('Reviews updated successfully.', '');
        } catch (\Throwable $th) {
            // Log::error('Review updated fetched error: ' . $th->getMessage());
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function destroy(Request $request, $course_id): JsonResponse
    {
        try {

            $checkData = CourseReview::where('course_id', $course_id)->get();

            if (!count($checkData)) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            CourseReview::where('course_id', $course_id)->delete();

            return sendSuccessResponse('Reviews deleted successfully.', '');
        } catch (\Throwable $th) {
            // Log::error('Review deleted error: ' . $th->getMessage());
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
