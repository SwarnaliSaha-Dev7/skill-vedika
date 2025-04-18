<?php

namespace App\Http\Controllers\API\Admin;

use Carbon\Carbon;
use App\Models\Blog;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\CourseContact;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\Exception;


class AdminDashboardController extends Controller
{
    public function adminDashboard(Request $request): JsonResponse
    {
        try {
            $data = [];
            $data['totalCourses'] = Course::get()->count();
            $data['totalActiveCourses'] = Course::get()->where('status',1)->count();
            $data['totalInactiveCourses'] = $data['totalCourses'] - $data['totalActiveCourses'];
            $data['totalBlogs'] = Blog::get()->count();
            $data['totalCourseContacts'] = CourseContact::get()->count();
            $data['totalCategory'] = Category::get()->count();

            $data['monthlyLeads'] = CourseContact::
            selectRaw("DATE_FORMAT(created_at, '%Y-%M') as month, COUNT(*) as total_count")
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%M')"))
            // ->orderBy(DB::raw("DATE_FORMAT(created_at, '%Y-%M')"))
            ->get();

            $data['latestCourseContacts'] = CourseContact::with([
                                                'courseDtls:id,course_name,category_id',
                                                'courseDtls.categoryDtls:id,name',
                                                'courseDtls.skills:name'
                                                ])
                                            ->orderBy('id','desc')
                                            ->limit(10)
                                            ->get();

            return sendSuccessResponse('Dashboard details fetched successfully.', $data);

        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
