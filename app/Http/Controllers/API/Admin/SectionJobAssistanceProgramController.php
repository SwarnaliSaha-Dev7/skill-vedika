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

            $path = public_path('uploads/CMS');

            //icon1 upload
            $fileName = null;
            $icon1_path = null;
            if ($request->hasFile('icon1')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('icon1')->getClientOriginalName();
                $request->icon1->move($path, $fileName);
                $icon1_path = "uploads/CMS/" . $fileName;

                if ($checkData->icon1) {
                    $this->delete_file($checkData->icon1);
                }
            } else {
                if($request->icon1){
                    $icon1_path = $request->icon1;
                    // $icon1_path = $checkData->icon1;
                }
                // else{
                //     $icon1_path = null;
                // }
            }

            //icon2 upload
            $fileName = null;
            $icon2_path = null;
            if ($request->hasFile('icon2')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('icon2')->getClientOriginalName();
                $request->icon2->move($path, $fileName);
                $icon2_path = "uploads/CMS/" . $fileName;

                if ($checkData->icon2) {
                    $this->delete_file($checkData->icon2);
                }
            } else {
                if($request->icon2){
                    $icon2_path = $request->icon2;
                    // $icon2_path = $checkData->icon2;
                }
                // else{
                //     $icon2_path = null;
                // }
            }

            //icon3 upload
            $fileName = null;
            $icon3_path = null;
            if ($request->hasFile('icon3')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('icon3')->getClientOriginalName();
                $request->icon3->move($path, $fileName);
                $icon3_path = "uploads/CMS/" . $fileName;

                if ($checkData->icon3) {
                    $this->delete_file($checkData->icon3);
                }
            } else {
                if($request->icon3){
                    $icon3_path = $request->icon3;
                    // $icon3_path = $checkData->icon3;
                }
                // else{
                //     $icon3_path = null;
                // }
            }

            //icon4 upload
            $fileName = null;
            $icon4_path = null;
            if ($request->hasFile('icon4')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('icon4')->getClientOriginalName();
                $request->icon4->move($path, $fileName);
                $icon4_path = "uploads/CMS/" . $fileName;

                if ($checkData->icon4) {
                    $this->delete_file($checkData->icon4);
                }
            } else {
                if($request->icon4){
                    $icon4_path = $request->icon4;
                    // $icon4_path = $checkData->icon4;
                }
                // else{
                //     $icon4_path = null;
                // }
            }

            //icon5 upload
            $fileName = null;
            $icon5_path = null;
            if ($request->hasFile('icon5')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('icon5')->getClientOriginalName();
                $request->icon5->move($path, $fileName);
                $icon5_path = "uploads/CMS/" . $fileName;

                if ($checkData->icon5) {
                    $this->delete_file($checkData->icon5);
                }
            } else {
                if($request->icon5){
                    $icon5_path = $request->icon5;
                    // $icon5_path = $checkData->icon5;
                }
                // else{
                //     $icon5_path = null;
                // }
            }

            //icon6 upload
            $fileName = null;
            $icon6_path = null;
            if ($request->hasFile('icon6')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('icon6')->getClientOriginalName();
                $request->icon6->move($path, $fileName);
                $icon6_path = "uploads/CMS/" . $fileName;

                if ($checkData->icon6) {
                    $this->delete_file($checkData->icon6);
                }
            } else {
                if($request->icon6){
                    $icon6_path = $request->icon6;
                    // $icon6_path = $checkData->icon6;
                }
                // else{
                //     $icon6_path = null;
                // }
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
                'icon1' => $icon1_path,
                'icon2' => $icon2_path,
                'icon3' => $icon3_path,
                'icon4' => $icon4_path,
                'icon5' => $icon5_path,
                'icon6' => $icon6_path,
            ];

            $checkData->update($updatedData);

            return sendSuccessResponse('Section Job Assistance Program details updated successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
