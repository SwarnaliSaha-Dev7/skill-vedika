<?php

namespace App\Http\Controllers\API\Admin;

use Validator;
use Illuminate\Http\Request;
use App\Models\PageContactUs;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\API\Exception;

class PageContactUsController extends Controller
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

            $data = PageContactUs::first();

            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }
            return sendSuccessResponse('Contact Us page details fetched successfully.', $data);
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

            $checkData = PageContactUs::first();

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $path = public_path('uploads/CMS');
            // if (!file_exists($path)) {
            //     mkdir($path, 0777, true);
            // }

            //desc_img upload
            $fileName = null;
            $desc_img_path = null;
            if ($request->hasFile('desc_img')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('desc_img')->getClientOriginalName();
                $request->desc_img->move($path, $fileName);
                $desc_img_path = "uploads/CMS/" . $fileName;

                if ($checkData->desc_img) {
                    $this->delete_file($checkData->desc_img);
                }
            } else {
                if($request->desc_img){
                    $desc_img_path = $request->desc_img;
                    // $desc_img_path = $checkData->desc_img;
                }
                // else{
                //     $desc_img_path = null;
                // }
            }


            $updatedData = [
                'title1' => $request->title1,
                'desc' => $request->desc,
                'desc_img' => $desc_img_path,
                'title2' => $request->title2,
                'email_label' => $request->email_label,
                'email_address' => $request->email_address,
                'phone_label' => $request->phone_label,
                'phone_no' => $request->phone_no,
                'location1_label' => $request->location1_label,
                'location1_address' => $request->location1_address,
                'location2_label' => $request->location2_label,
                'location2_address' => $request->location2_address,
            ];

            $checkData->update($updatedData);

            return sendSuccessResponse('Contact Us page details updated successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
