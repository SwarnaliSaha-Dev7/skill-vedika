<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PageBecomeInstructors;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\API\Exception;
use Validator;

class PageBecomeInstructorsController extends Controller
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

            $data = PageBecomeInstructors::first();

            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }
            return sendSuccessResponse('Become Instructors page details fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function update(Request $request): JsonResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'title1' => 'required',
            ]);

            if ($validator->fails()) {
                return sendErrorResponse('Validation Error.', $validator->errors(), 400);
            }

            $checkData = PageBecomeInstructors::first();

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $path = public_path('uploads/CMS');
            // if (!file_exists($path)) {
            //     mkdir($path, 0777, true);
            // }

            //iamge upload
            $fileName = null;
            $iamge_path = null;
            if ($request->hasFile('iamge')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('iamge')->getClientOriginalName();
                $request->iamge->move($path, $fileName);
                $iamge_path = "uploads/CMS/" . $fileName;

                if ($checkData->iamge) {
                    $this->delete_file($checkData->iamge);
                }
            } else {
                if($request->iamge){
                    $iamge_path = $request->iamge;
                    // $iamge_path = $checkData->iamge;
                }
                // else{
                //     $iamge_path = null;
                // }
            }

            $updatedData = [
                'title1' => $request->title1,
                'small_desc' => $request->small_desc,
                'iamge' => $iamge_path,
                'form_title' => $request->form_title,
            ];

            $checkData->update($updatedData);

            return sendSuccessResponse('Become Instructors page details updated successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
