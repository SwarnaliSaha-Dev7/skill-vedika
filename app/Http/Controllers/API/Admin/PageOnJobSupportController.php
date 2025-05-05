<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use App\Models\PageOnJobSupport;
use App\Http\Controllers\API\Exception;
use Validator;

class PageOnJobSupportController extends Controller
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

            $data = PageOnJobSupport::first();

            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            return sendSuccessResponse('On Job Support page details fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function update(Request $request): JsonResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'sec1_title' => 'required',
            ]);

            if ($validator->fails()) {
                return sendErrorResponse('Validation Error.', $validator->errors(), 400);
            }

            $checkData = PageOnJobSupport::first();

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $path = public_path('uploads/CMS');
            // if (!file_exists($path)) {
            //     mkdir($path, 0777, true);
            // }


            //sec1_img upload
            $fileName = null;
            $sec1_img_path = null;
            if ($request->hasFile('sec1_img')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('sec1_img')->getClientOriginalName();
                $request->sec1_img->move($path, $fileName);
                $sec1_img_path = "uploads/CMS/" . $fileName;

                if ($checkData->sec1_img) {
                    $this->delete_file($checkData->sec1_img);
                }
            } else {
                if($request->sec1_img){
                    $sec1_img_path = $request->sec1_img;
                    // $sec1_img_path = $checkData->sec1_img;
                }
                // else{
                //     $sec1_img_path = null;
                // }
            }

            //sec2_img upload
            $fileName = null;
            $sec2_img_path = null;
            if ($request->hasFile('sec2_img')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('sec2_img')->getClientOriginalName();
                $request->sec2_img->move($path, $fileName);
                $sec2_img_path = "uploads/CMS/" . $fileName;

                if ($checkData->sec2_img) {
                    $this->delete_file($checkData->sec2_img);
                }
            } else {
                if($request->sec2_img){
                    $sec2_img_path = $request->sec2_img;
                    // $sec2_img_path = $checkData->sec2_img;
                }
                // else{
                //     $sec2_img_path = null;
                // }
            }

            //sec3_img upload
            $fileName = null;
            $sec3_img_path = null;
            if ($request->hasFile('sec3_img')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('sec3_img')->getClientOriginalName();
                $request->sec3_img->move($path, $fileName);
                $sec3_img_path = "uploads/CMS/" . $fileName;

                if ($checkData->sec3_img) {
                    $this->delete_file($checkData->sec3_img);
                }
            } else {
                if($request->sec3_img){
                    $sec3_img_path = $request->sec3_img;
                    // $sec3_img_path = $checkData->sec3_img;
                }
                // else{
                //     $sec3_img_path = null;
                // }
            }

            //sec4_point1_img upload
            $fileName = null;
            $sec4_point1_img_path = null;
            if ($request->hasFile('sec4_point1_img')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('sec4_point1_img')->getClientOriginalName();
                $request->sec4_point1_img->move($path, $fileName);
                $sec4_point1_img_path = "uploads/CMS/" . $fileName;

                if ($checkData->sec4_point1_img) {
                    $this->delete_file($checkData->sec4_point1_img);
                }
            } else {
                if($request->sec4_point1_img){
                    $sec4_point1_img_path = $request->sec4_point1_img;
                    // $sec4_point1_img_path = $checkData->sec4_point1_img;
                }
                // else{
                //     $sec4_point1_img_path = null;
                // }
            }

            //sec4_point2_img upload
            $fileName = null;
            $sec4_point2_img_path = null;
            if ($request->hasFile('sec4_point2_img')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('sec4_point2_img')->getClientOriginalName();
                $request->sec4_point2_img->move($path, $fileName);
                $sec4_point2_img_path = "uploads/CMS/" . $fileName;

                if ($checkData->sec4_point2_img) {
                    $this->delete_file($checkData->sec4_point2_img);
                }
            } else {
                if($request->sec4_point2_img){
                    $sec4_point2_img_path = $request->sec4_point2_img;
                    // $sec4_point2_img_path = $checkData->sec4_point2_img;
                }
                // else{
                //     $sec4_point2_img_path = null;
                // }
            }

            //sec4_point3_img upload
            $fileName = null;
            $sec4_point3_img_path = null;
            if ($request->hasFile('sec4_point3_img')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('sec4_point3_img')->getClientOriginalName();
                $request->sec4_point3_img->move($path, $fileName);
                $sec4_point3_img_path = "uploads/CMS/" . $fileName;

                if ($checkData->sec4_point3_img) {
                    $this->delete_file($checkData->sec4_point3_img);
                }
            } else {
                if($request->sec4_point3_img){
                    $sec4_point3_img_path = $request->sec4_point3_img;
                    // $sec4_point3_img_path = $checkData->sec4_point3_img;
                }
                // else{
                //     $sec4_point3_img_path = null;
                // }
            }

            //sec4_point4_img upload
            $fileName = null;
            $sec4_point4_img_path = null;
            if ($request->hasFile('sec4_point4_img')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('sec4_point4_img')->getClientOriginalName();
                $request->sec4_point4_img->move($path, $fileName);
                $sec4_point4_img_path = "uploads/CMS/" . $fileName;

                if ($checkData->sec4_point4_img) {
                    $this->delete_file($checkData->sec4_point4_img);
                }
            } else {
                if($request->sec4_point4_img){
                    $sec4_point4_img_path = $request->sec4_point4_img;
                    // $sec4_point4_img_path = $checkData->sec4_point4_img;
                }
                // else{
                //     $sec4_point4_img_path = null;
                // }
            }

            //sec4_point5_img upload
            $fileName = null;
            $sec4_point5_img_path = null;
            if ($request->hasFile('sec4_point5_img')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('sec4_point5_img')->getClientOriginalName();
                $request->sec4_point5_img->move($path, $fileName);
                $sec4_point5_img_path = "uploads/CMS/" . $fileName;

                if ($checkData->sec4_point5_img) {
                    $this->delete_file($checkData->sec4_point5_img);
                }
            } else {
                if($request->sec4_point5_img){
                    $sec4_point5_img_path = $request->sec4_point5_img;
                    // $sec4_point5_img_path = $checkData->sec4_point5_img;
                }
                // else{
                //     $sec4_point5_img_path = null;
                // }
            }

            //sec6_img upload
            $fileName = null;
            $sec6_img_path = null;
            if ($request->hasFile('sec6_img')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('sec6_img')->getClientOriginalName();
                $request->sec6_img->move($path, $fileName);
                $sec6_img_path = "uploads/CMS/" . $fileName;

                if ($checkData->sec6_img) {
                    $this->delete_file($checkData->sec6_img);
                }
            } else {
                if($request->sec6_img){
                    $sec6_img_path = $request->sec6_img;
                    // $sec6_img_path = $checkData->sec6_img;
                }
                // else{
                //     $sec6_img_path = null;
                // }
            }

            //sec_ready_to_empower_workforce_img upload
            $fileName = null;
            $sec_ready_to_empower_workforce_img_path = null;
            if ($request->hasFile('sec_ready_to_empower_workforce_img')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('sec_ready_to_empower_workforce_img')->getClientOriginalName();
                $request->sec_ready_to_empower_workforce_img->move($path, $fileName);
                $sec_ready_to_empower_workforce_img_path = "uploads/CMS/" . $fileName;

                if ($checkData->sec_ready_to_empower_workforce_img) {
                    $this->delete_file($checkData->sec_ready_to_empower_workforce_img);
                }
            } else {
                if($request->sec_ready_to_empower_workforce_img){
                    $sec_ready_to_empower_workforce_img_path = $request->sec_ready_to_empower_workforce_img;
                    // $sec_ready_to_empower_workforce_img_path = $checkData->sec_ready_to_empower_workforce_img;
                }
                // else{
                //     $sec_ready_to_empower_workforce_img_path = null;
                // }
            }

            $updatedData = $request->all();
            $updatedData['sec1_img'] = $sec1_img_path;
            $updatedData['sec2_img'] = $sec2_img_path;
            $updatedData['sec3_img'] = $sec3_img_path;
            $updatedData['sec4_point1_img'] = $sec4_point1_img_path;
            $updatedData['sec4_point2_img'] = $sec4_point2_img_path;
            $updatedData['sec4_point3_img'] = $sec4_point3_img_path;
            $updatedData['sec4_point4_img'] = $sec4_point4_img_path;
            $updatedData['sec4_point5_img'] = $sec4_point5_img_path;
            $updatedData['sec6_img'] = $sec6_img_path;
            $updatedData['sec_ready_to_empower_workforce_img'] = $sec_ready_to_empower_workforce_img_path;

            $checkData->update($updatedData);

            return sendSuccessResponse('On Job Support page details updated successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
