<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SectionJobAssistanceProgram;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\API\Exception;
use Validator;

class SectionJobAssistanceProgramController extends Controller
{
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

    public function updatedDataFetch(Request $request): JsonResponse
    {
        try {

            $data = SectionJobAssistanceProgram::first();

            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }
            return sendSuccessResponse('Section Job Assistance Program details fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function update(Request $request): JsonResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'title' => 'required',
            ]);

            if ($validator->fails()) {
                return sendErrorResponse('Validation Error.', $validator->errors(), 400);
            }

            $checkData = SectionJobAssistanceProgram::first();

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }


            $updatedData = [
                'title' => $request->title,
                'short_desc' => $request->short_desc,
                'lebel1' => $request->lebel1,
                'content1' => $request->content1,
                'lebel2' => $request->lebel2,
                'content2' => $request->content2,
                'lebel3' => $request->lebel3,
                'content3' => $request->content3,
                'lebel4' => $request->lebel4,
                'content4' => $request->content4,
                'lebel5' => $request->lebel5,
                'content5' => $request->content5,
                'lebel6' => $request->lebel6,
                'content6' => $request->content6,
            ];

            $checkData->update($updatedData);

            return sendSuccessResponse('Section Job Assistance Program details updated successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
