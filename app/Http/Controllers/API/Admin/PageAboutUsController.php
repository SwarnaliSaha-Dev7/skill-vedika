<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PageAboutUs;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\API\Exception;
use Validator;

class PageAboutUsController extends Controller
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

            $data = PageAboutUs::first();

            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }
            return sendSuccessResponse('About Us page details fetched successfully.', $data);
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

            $checkData = PageAboutUs::first();

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $path = public_path('uploads/CMS');
            // if (!file_exists($path)) {
            //     mkdir($path, 0777, true);
            // }

            //small_desc_img upload
            $fileName = null;
            $small_desc_img_path = null;
            if ($request->hasFile('small_desc_img')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('small_desc_img')->getClientOriginalName();
                $request->small_desc_img->move($path, $fileName);
                $small_desc_img_path = "uploads/CMS/" . $fileName;

                if ($checkData->small_desc_img) {
                    $this->delete_file($checkData->small_desc_img);
                }
            } else {
                if($request->small_desc_img){
                    $small_desc_img_path = $request->small_desc_img;
                    // $small_desc_img_path = $checkData->small_desc_img;
                }
                // else{
                //     $small_desc_img_path = null;
                // }
            }


            //content_image upload
            $fileName = null;
            $content_image_path = null;
            if ($request->hasFile('content_image')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('content_image')->getClientOriginalName();
                $request->content_image->move($path, $fileName);
                $content_image_path = "uploads/CMS/" . $fileName;

                if ($checkData->content_image) {
                    $this->delete_file($checkData->content_image);
                }
            } else {
                if($request->content_image){
                    $content_image_path = $request->content_image;
                    // $content_image_path = $checkData->content_image;
                }
                // else{
                //     $content_image_path = null;
                // }
            }

            $updatedData = [
                'title1' => $request->title1,
                'small_desc' => $request->small_desc,
                'small_desc_img' => $small_desc_img_path,
                'title2' => $request->title2,
                'content' => $request->content,
                'content_image' => $content_image_path,
            ];

            $checkData->update($updatedData);

            return sendSuccessResponse('About Us page details updated successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
