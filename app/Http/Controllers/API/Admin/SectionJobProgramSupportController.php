<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SectionJobProgramSupport;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\API\Exception;
use Validator;

class SectionJobProgramSupportController extends Controller
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

            $data = SectionJobProgramSupport::first();

            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }
            return sendSuccessResponse('Section Job Program Support details fetched successfully.', $data);
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

            $checkData = SectionJobProgramSupport::first();

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $path = public_path('uploads/CMS');
            // if (!file_exists($path)) {
            //     mkdir($path, 0777, true);
            // }

            //image upload
            $fileName = null;
            $image_path = null;
            if ($request->hasFile('image')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('image')->getClientOriginalName();
                $request->image->move($path, $fileName);
                $image_path = "uploads/CMS/" . $fileName;

                if ($checkData->image) {
                    $this->delete_file($checkData->image);
                }
            } else {
                if($request->image){
                    $image_path = $request->image;
                    // $image_path = $checkData->image;
                }
                // else{
                //     $image_path = null;
                // }
            }

            $updatedData = [
                'title' => $request->title,
                'desc' => $request->desc,
                'lebel1' => $request->lebel1,
                'lebel2' => $request->lebel2,
                'lebel3' => $request->lebel3,
                'image' => $image_path,
            ];

            $checkData->update($updatedData);

            return sendSuccessResponse('Section Job Program Support details updated successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
