<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SectionKeyFeature;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\API\Exception;
use Validator;

class SectionKeyFeatureController extends Controller
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

            $data = SectionKeyFeature::first();

            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }
            return sendSuccessResponse('Section Key Feature details fetched successfully.', $data);
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

            $checkData = SectionKeyFeature::first();

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $path = public_path('uploads/CMS');
            // if (!file_exists($path)) {
            //     mkdir($path, 0777, true);
            // }

            //desc_image upload
            $fileName = null;
            $desc_image_path = null;
            if ($request->hasFile('desc_image')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('desc_image')->getClientOriginalName();
                $request->desc_image->move($path, $fileName);
                $desc_image_path = "uploads/CMS/" . $fileName;

                if ($checkData->desc_image) {
                    $this->delete_file($checkData->desc_image);
                }
            } else {
                if($request->desc_image){
                    $desc_image_path = $request->desc_image;
                    // $desc_image_path = $checkData->desc_image;
                }
                // else{
                //     $desc_image_path = null;
                // }
            }

            $updatedData = [
                'title' => $request->title,
                'desc' => $request->desc,
                'desc_image' => $desc_image_path,
                'lebel1' => $request->lebel1,
                'content1' => $request->content1,
                'lebel2' => $request->lebel2,
                'content2' => $request->content2,
                'lebel3' => $request->lebel3,
                'content3' => $request->content3,
                'lebel4' => $request->lebel4,
                'content4' => $request->content4,
            ];

            $checkData->update($updatedData);

            return sendSuccessResponse('Section Key Feature details updated successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
