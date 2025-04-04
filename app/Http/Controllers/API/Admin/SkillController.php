<?php

namespace App\Http\Controllers\API\Admin;

use Validator;

use App\Models\Skill;
use App\Models\CoursesSkill;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\Exception;

class SkillController extends Controller
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

            $duplicate = Skill::where('name', $request->name)->exists();

            if ($duplicate) {
                return sendErrorResponse('The skill is already in use.', '', 409);
            }

            $storeInfo = Skill::create([
                            'name' => $request->name,
                        ]);

            return sendSuccessResponse('Skill inserted successfully.', '');
        } catch (\Throwable $th) {
            // Log::error('Skill inserted error: ' . $th->getMessage());
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function listing(Request $request): JsonResponse
    {
        try {

            $data = Skill::
                        orderBy('id','desc')
                        // ->get();
                        ->paginate(15);

            // if (!$data) {
            //     return sendErrorResponse('Data not found.', '', 404);
            // }

            return sendSuccessResponse('All skills fetched successfully.', $data);
        } catch (\Throwable $th) {
            // Log::error('All skills fetched error: ' . $th->getMessage());
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function updatedDataFetch(Request $request, $id): JsonResponse
    {
        try {

            $data = Skill::find($id);

            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }
            return sendSuccessResponse('Skill data fetched successfully.', $data);
        } catch (\Throwable $th) {
            // Log::error('Skill data fetched error: ' . $th->getMessage());
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

            $checkData = Skill::find($id);

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $duplicate = Skill::where('name', $request->name)
                                ->where('id', '!=', $id)
                                ->exists();

            if ($duplicate) {
                return sendErrorResponse('The skill is already in use.', '', 409);
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

            $storeInfo = Skill::where('id', $id)
                                        ->update(['name' => $request->name,]);

            return sendSuccessResponse('Skill details updated successfully.', '');
        } catch (\Throwable $th) {
            // Log::error('Skill details updated fetched error: ' . $th->getMessage());
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function destroy(Request $request, $id): JsonResponse
    {
        try {

            $checkData = Skill::find($id);

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $isUsedInCourse = CoursesSkill::where('skill_id',$id)->exists();

            if ($isUsedInCourse) {
                return sendErrorResponse('The skill is already in use; you can not delete it.', '', 409);
            }

            // if ($checkData->category_logo) {
            //     $this->delete_file($checkData->category_logo);
            // }

            $checkData->delete();

            return sendSuccessResponse('Skill details deleted successfully.', '');
        } catch (\Throwable $th) {
            // Log::error('Skill deleted error: ' . $th->getMessage());
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
