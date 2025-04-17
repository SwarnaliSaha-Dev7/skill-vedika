<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\Exception;


class AdminDashboardController extends Controller
{
    public function adminDashboard(Request $request): JsonResponse
    {
        try {
            $data = [];
            $data['totalCourse'] = Course::get()->count();

            return sendSuccessResponse('All courses fetched successfully.', $data);

        } catch (\Throwable $th) {
            // Log::error('All courses fetched error: ' . $th->getMessage());
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
