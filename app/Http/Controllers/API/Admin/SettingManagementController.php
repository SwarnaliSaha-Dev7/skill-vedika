<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SettingManagement;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\API\Exception;
use Validator;

class SettingManagementController extends Controller
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

            $data = SettingManagement::first();

            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }
            return sendSuccessResponse('Settings data fetched successfully.', $data);
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

            $checkData = SettingManagement::first();

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $path = public_path('uploads/CMS');
            // if (!file_exists($path)) {
            //     mkdir($path, 0777, true);
            // }

            //default_course_image upload
            $fileName = null;
            $default_course_image_path = null;
            if ($request->hasFile('default_course_image')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('default_course_image')->getClientOriginalName();
                $request->default_course_image->move($path, $fileName);
                $default_course_image_path = "uploads/CMS/" . $fileName;

                if ($checkData->default_course_image) {
                    $this->delete_file($checkData->default_course_image);
                }
            } else {
                if($request->default_course_image){
                    $default_course_image_path = $request->default_course_image;
                    // $default_course_image_path = $checkData->default_course_image;
                }
                // else{
                //     $default_course_image_path = null;
                // }
            }


            //default_blog_image upload
            $fileName = null;
            $default_blog_image_path = null;
            if ($request->hasFile('default_blog_image')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('default_blog_image')->getClientOriginalName();
                $request->default_blog_image->move($path, $fileName);
                $default_blog_image_path = "uploads/CMS/" . $fileName;

                if ($checkData->default_blog_image) {
                    $this->delete_file($checkData->default_blog_image);
                }
            } else {
                if($request->default_blog_image){
                    $default_blog_image_path = $request->default_blog_image;
                    // $default_blog_image_path = $checkData->default_blog_image;
                }
                // else{
                //     $default_blog_image_path = null;
                // }
            }

            //header_logo upload
            $fileName = null;
            $header_logo_path = null;
            if ($request->hasFile('header_logo')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('header_logo')->getClientOriginalName();
                $request->header_logo->move($path, $fileName);
                $header_logo_path = "uploads/CMS/" . $fileName;

                if ($checkData->header_logo) {
                    $this->delete_file($checkData->header_logo);
                }
            } else {
                if($request->header_logo){
                    $header_logo_path = $request->header_logo;
                    // $header_logo_path = $checkData->header_logo;
                }
                // else{
                //     $header_logo_path = null;
                // }
            }


            //footer_logo upload
            $fileName = null;
            $footer_logo_path = null;
            if ($request->hasFile('footer_logo')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('footer_logo')->getClientOriginalName();
                $request->footer_logo->move($path, $fileName);
                $footer_logo_path = "uploads/CMS/" . $fileName;

                if ($checkData->footer_logo) {
                    $this->delete_file($checkData->footer_logo);
                }
            } else {
                if($request->footer_logo){
                    $footer_logo_path = $request->footer_logo;
                    // $footer_logo_path = $checkData->footer_logo;
                }
                // else{
                //     $footer_logo_path = null;
                // }
            }

            $updatedData = [
                'site_url' => $request->site_url,
                'title' => $request->title,
                'default_course_image' => $default_course_image_path,
                'default_blog_image' => $default_blog_image_path,
                'default_demo_video_url' => $request->default_demo_video_url,
                'phone_no' => $request->phone_no,
                'email' => $request->email,
                'location_1_address' => $request->location_1_address,
                'location_2_address' => $request->location_2_address,
                'facebook_url' => $request->facebook_url,
                'instagram_url' => $request->instagram_url,
                'linkedIn_url' => $request->linkedIn_url,
                'youtube_url' => $request->youtube_url,
                'twitter_url' => $request->twitter_url,
                'header_logo' => $header_logo_path,
                'footer_logo' => $footer_logo_path,
                'footer_short_description' => $request->footer_short_description,
                'footer_copy_right' => $request->footer_copy_right,
                'footer_quick_links' => $request->footer_quick_links,
                'footer_support' => $request->footer_support,
                'footer_disclaimer' => $request->footer_disclaimer,
                'footer_category' => $request->footer_category,
                'google_analytics' => $request->google_analytics,
                'default_color_theme' => $request->default_color_theme,
                'current_color_theme' => $request->current_color_theme,
            ];

            $checkData->update($updatedData);

            return sendSuccessResponse('Settings updated successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
