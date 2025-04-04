<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageBlogDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\API\Exception;
use Validator;

class PageBlogDetailController extends Controller
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

            $data = PageBlogDetail::first();

            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }
            return sendSuccessResponse('Blog Detail page details fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function update(Request $request): JsonResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'header_title' => 'required',
            ]);

            if ($validator->fails()) {
                return sendErrorResponse('Validation Error.', $validator->errors(), 400);
            }

            $checkData = PageBlogDetail::first();

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $path = public_path('uploads/CMS');
            // if (!file_exists($path)) {
            //     mkdir($path, 0777, true);
            // }

            //header_img upload
            $fileName = null;
            $header_img_path = null;
            if ($request->hasFile('header_img')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('header_img')->getClientOriginalName();
                $request->header_img->move($path, $fileName);
                $header_img_path = "uploads/CMS/" . $fileName;

                if ($checkData->header_img) {
                    $this->delete_file($checkData->header_img);
                }
            } else {
                if($request->header_img){
                    $header_img_path = $request->header_img;
                    // $header_img_path = $checkData->header_img;
                }
                // else{
                //     $header_img_path = null;
                // }
            }

            $updatedData = [
                'header_title' => $request->header_title,
                'header_desc' => $request->header_desc,
                'header_img' => $header_img_path,
            ];

            $checkData->update($updatedData);

            return sendSuccessResponse('Blog detail page details updated successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
