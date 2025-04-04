<?php

namespace App\Http\Controllers\API\Admin;

use Validator;
use App\Models\Blog;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\Exception;

class CategoryController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                return sendErrorResponse('Validation Error.', $validator->errors(), 400);
            }

            $duplicate = Category::where('name', $request->name)->exists();

            if ($duplicate) {
                return sendErrorResponse('The category is already in use.', '', 409);
            }

            // $path = public_path('uploads/categories');
            // if (!file_exists($path)) {
            //     mkdir($path, 0777, true);
            // }

            // $fileName = null;
            // $filePath = null;
            // if ($request->hasFile('category_logo')) {
            //     $fileName = time() . rand(1000, 9999) . "_" . $request->file('category_logo')->getClientOriginalName();
            //     $request->category_logo->move($path, $fileName);
            //     $filePath = "uploads/categories/" . $fileName;
            // }

            $storeInfo = Category::create([
                            'name' => $request->name,
                        ]);

            return sendSuccessResponse('Category inserted successfully.', '');
        } catch (\Throwable $th) {
            // Log::error('Category inserted error: ' . $th->getMessage());
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function listing(Request $request): JsonResponse
    {
        try {

            // $pageNumber = request()->input('page', 1); // Get 'page' parameter from the request, default to 1
            // $perPage = 15;

            $data = Category::
                        orderBy('id','desc')
                        // ->get();
                        ->paginate(15);

            // if (!$data) {
            //     return sendErrorResponse('Data not found.', '', 404);
            // }

            return sendSuccessResponse('All categories fetched successfully.', $data);
        } catch (\Throwable $th) {
            // Log::error('All categories fetched error: ' . $th->getMessage());
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function updatedDataFetch(Request $request, $id): JsonResponse
    {
        try {

            $data = Category::find($id);

            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }
            return sendSuccessResponse('Category data fetched successfully.', $data);
        } catch (\Throwable $th) {
            // Log::error('Category data fetched error: ' . $th->getMessage());
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                return sendErrorResponse('Validation Error.', $validator->errors(), 400);
            }

            $checkData = Category::find($id);

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $duplicate = Category::where('name', $request->name)
                                ->where('id', '!=', $id)
                                ->exists();

            if ($duplicate) {
                return sendErrorResponse('The category is already in use.', '', 409);
            }

            // $path = public_path('uploads/categories');
            // if (!file_exists($path)) {
            //     mkdir($path, 0777, true);
            // }

            // $fileName = null;
            // $filePath = $checkData->category_logo;
            // if ($request->hasFile('category_logo')) {
            //     $fileName = time() . rand(1000, 9999) . "_" . $request->file('category_logo')->getClientOriginalName();
            //     $request->category_logo->move($path, $fileName);
            //     $filePath = "uploads/categories/" . $fileName;

            //     if ($checkData->category_logo) {
            //         $this->delete_file($checkData->category_logo);
            //     }
            // }

            $storeInfo = Category::where('id', $id)
                                        ->update(['name' => $request->name,]);

            return sendSuccessResponse('Category details updated successfully.', '');
        } catch (\Throwable $th) {
            // Log::error('Category details updated fetched error: ' . $th->getMessage());
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function destroy(Request $request, $id): JsonResponse
    {
        try {

            $checkData = Category::find($id);

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $isUsedInCourse = Course::where('category_id',$id)->exists();

            $isUsedInBlog = Blog::where('category_id',$id)->exists();

            // $isUsedInWebinar = DB::table('webinars')
            // ->where('category_id', '=', $id)
            // ->exists();

            // if ($isUsedInBlog || $isUsedInCourse || $isUsedInWebinar) {
            if ($isUsedInCourse || $isUsedInBlog) {
                return sendErrorResponse('The category is already in use; you can not delete it.', '', 409);
            }

            // if ($checkData->category_logo) {
            //     $this->delete_file($checkData->category_logo);
            // }

            $checkData->delete();

            return sendSuccessResponse('Category details deleted successfully.', '');
        } catch (\Throwable $th) {
            // Log::error('Category deleted error: ' . $th->getMessage());
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
