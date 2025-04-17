<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\Exception;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    public function courseListing(Request $request): JsonResponse
    {
        try {

            $courses = Course::select('id', 'course_name')
                            ->orderBy('id','desc')
                            ->get();

            return sendSuccessResponse('All courses fetched successfully.', $courses);

        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
