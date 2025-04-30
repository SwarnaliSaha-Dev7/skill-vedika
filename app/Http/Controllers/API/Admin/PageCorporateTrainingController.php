<?php

namespace App\Http\Controllers\API\Admin;

use Validator;
use Illuminate\Http\Request;
use App\Models\HrProfessionalFaq;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\PageCorporateTraining;
use App\Http\Controllers\API\Exception;

class PageCorporateTrainingController extends Controller
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

            $data = PageCorporateTraining::first();

            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $data->hr_professional_faqs = HrProfessionalFaq::get();
            return sendSuccessResponse('Corporate Training page details fetched successfully.', $data);
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

            $checkData = PageCorporateTraining::first();

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $path = public_path('uploads/CMS');
            // if (!file_exists($path)) {
            //     mkdir($path, 0777, true);
            // }

            // //desc_img upload
            // $fileName = null;
            // $desc_img_path = null;
            // if ($request->hasFile('desc_img')) {
            //     $fileName = time() . rand(1000, 9999) . "_" . $request->file('desc_img')->getClientOriginalName();
            //     $request->desc_img->move($path, $fileName);
            //     $desc_img_path = "uploads/CMS/" . $fileName;

            //     if ($checkData->desc_img) {
            //         $this->delete_file($checkData->desc_img);
            //     }
            // } else {
            //     if($request->desc_img){
            //         $desc_img_path = $request->desc_img;
            //         // $desc_img_path = $checkData->desc_img;
            //     }
            //     // else{
            //     //     $desc_img_path = null;
            //     // }
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

            //sec_portfolio_option1_img upload
            $fileName = null;
            $sec_portfolio_option1_img_path = null;
            if ($request->hasFile('sec_portfolio_option1_img')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('sec_portfolio_option1_img')->getClientOriginalName();
                $request->sec_portfolio_option1_img->move($path, $fileName);
                $sec_portfolio_option1_img_path = "uploads/CMS/" . $fileName;

                if ($checkData->sec_portfolio_option1_img) {
                    $this->delete_file($checkData->sec_portfolio_option1_img);
                }
            } else {
                if($request->sec_portfolio_option1_img){
                    $sec_portfolio_option1_img_path = $request->sec_portfolio_option1_img;
                    // $sec_portfolio_option1_img_path = $checkData->sec_portfolio_option1_img;
                }
                // else{
                //     $sec_portfolio_option1_img_path = null;
                // }
            }

            //sec_portfolio_option2_img upload
            $fileName = null;
            $sec_portfolio_option2_img_path = null;
            if ($request->hasFile('sec_portfolio_option2_img')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('sec_portfolio_option2_img')->getClientOriginalName();
                $request->sec_portfolio_option2_img->move($path, $fileName);
                $sec_portfolio_option2_img_path = "uploads/CMS/" . $fileName;

                if ($checkData->sec_portfolio_option2_img) {
                    $this->delete_file($checkData->sec_portfolio_option2_img);
                }
            } else {
                if($request->sec_portfolio_option2_img){
                    $sec_portfolio_option2_img_path = $request->sec_portfolio_option2_img;
                    // $sec_portfolio_option2_img_path = $checkData->sec_portfolio_option2_img;
                }
                // else{
                //     $sec_portfolio_option2_img_path = null;
                // }
            }

            //sec_portfolio_option3_img upload
            $fileName = null;
            $sec_portfolio_option3_img_path = null;
            if ($request->hasFile('sec_portfolio_option3_img')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('sec_portfolio_option3_img')->getClientOriginalName();
                $request->sec_portfolio_option3_img->move($path, $fileName);
                $sec_portfolio_option3_img_path = "uploads/CMS/" . $fileName;

                if ($checkData->sec_portfolio_option3_img) {
                    $this->delete_file($checkData->sec_portfolio_option3_img);
                }
            } else {
                if($request->sec_portfolio_option3_img){
                    $sec_portfolio_option3_img_path = $request->sec_portfolio_option3_img;
                    // $sec_portfolio_option3_img_path = $checkData->sec_portfolio_option3_img;
                }
                // else{
                //     $sec_portfolio_option3_img_path = null;
                // }
            }

            //sec_portfolio_option4_img upload
            $fileName = null;
            $sec_portfolio_option4_img_path = null;
            if ($request->hasFile('sec_portfolio_option4_img')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('sec_portfolio_option4_img')->getClientOriginalName();
                $request->sec_portfolio_option4_img->move($path, $fileName);
                $sec_portfolio_option4_img_path = "uploads/CMS/" . $fileName;

                if ($checkData->sec_portfolio_option4_img) {
                    $this->delete_file($checkData->sec_portfolio_option4_img);
                }
            } else {
                if($request->sec_portfolio_option4_img){
                    $sec_portfolio_option4_img_path = $request->sec_portfolio_option4_img;
                    // $sec_portfolio_option4_img_path = $checkData->sec_portfolio_option4_img;
                }
                // else{
                //     $sec_portfolio_option4_img_path = null;
                // }
            }

            //sec_portfolio_option5_img upload
            $fileName = null;
            $sec_portfolio_option5_img_path = null;
            if ($request->hasFile('sec_portfolio_option5_img')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('sec_portfolio_option5_img')->getClientOriginalName();
                $request->sec_portfolio_option5_img->move($path, $fileName);
                $sec_portfolio_option5_img_path = "uploads/CMS/" . $fileName;

                if ($checkData->sec_portfolio_option5_img) {
                    $this->delete_file($checkData->sec_portfolio_option5_img);
                }
            } else {
                if($request->sec_portfolio_option5_img){
                    $sec_portfolio_option5_img_path = $request->sec_portfolio_option5_img;
                    // $sec_portfolio_option5_img_path = $checkData->sec_portfolio_option5_img;
                }
                // else{
                //     $sec_portfolio_option5_img_path = null;
                // }
            }

            //sec_portfolio_option6_img upload
            $fileName = null;
            $sec_portfolio_option6_img_path = null;
            if ($request->hasFile('sec_portfolio_option6_img')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('sec_portfolio_option6_img')->getClientOriginalName();
                $request->sec_portfolio_option6_img->move($path, $fileName);
                $sec_portfolio_option6_img_path = "uploads/CMS/" . $fileName;

                if ($checkData->sec_portfolio_option6_img) {
                    $this->delete_file($checkData->sec_portfolio_option6_img);
                }
            } else {
                if($request->sec_portfolio_option6_img){
                    $sec_portfolio_option6_img_path = $request->sec_portfolio_option6_img;
                    // $sec_portfolio_option6_img_path = $checkData->sec_portfolio_option6_img;
                }
                // else{
                //     $sec_portfolio_option6_img_path = null;
                // }
            }

            //sec_corporate_training_sec1_img upload
            $fileName = null;
            $sec_corporate_training_sec1_img_path = null;
            if ($request->hasFile('sec_corporate_training_sec1_img')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('sec_corporate_training_sec1_img')->getClientOriginalName();
                $request->sec_corporate_training_sec1_img->move($path, $fileName);
                $sec_corporate_training_sec1_img_path = "uploads/CMS/" . $fileName;

                if ($checkData->sec_corporate_training_sec1_img) {
                    $this->delete_file($checkData->sec_corporate_training_sec1_img);
                }
            } else {
                if($request->sec_corporate_training_sec1_img){
                    $sec_corporate_training_sec1_img_path = $request->sec_corporate_training_sec1_img;
                    // $sec_corporate_training_sec1_img_path = $checkData->sec_corporate_training_sec1_img;
                }
                // else{
                //     $sec_corporate_training_sec1_img_path = null;
                // }
            }

            //sec_corporate_training_sec2_img upload
            $fileName = null;
            $sec_corporate_training_sec2_img_path = null;
            if ($request->hasFile('sec_corporate_training_sec2_img')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('sec_corporate_training_sec2_img')->getClientOriginalName();
                $request->sec_corporate_training_sec2_img->move($path, $fileName);
                $sec_corporate_training_sec2_img_path = "uploads/CMS/" . $fileName;

                if ($checkData->sec_corporate_training_sec2_img) {
                    $this->delete_file($checkData->sec_corporate_training_sec2_img);
                }
            } else {
                if($request->sec_corporate_training_sec2_img){
                    $sec_corporate_training_sec2_img_path = $request->sec_corporate_training_sec2_img;
                    // $sec_corporate_training_sec2_img_path = $checkData->sec_corporate_training_sec2_img;
                }
                // else{
                //     $sec_corporate_training_sec2_img_path = null;
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
            $updatedData['sec_portfolio_option1_img'] = $sec_portfolio_option1_img_path;
            $updatedData['sec_portfolio_option2_img'] = $sec_portfolio_option2_img_path;
            $updatedData['sec_portfolio_option3_img'] = $sec_portfolio_option3_img_path;
            $updatedData['sec_portfolio_option4_img'] = $sec_portfolio_option4_img_path;
            $updatedData['sec_portfolio_option5_img'] = $sec_portfolio_option5_img_path;
            $updatedData['sec_portfolio_option6_img'] = $sec_portfolio_option6_img_path;
            $updatedData['sec_corporate_training_sec1_img'] = $sec_corporate_training_sec1_img_path;
            $updatedData['sec_corporate_training_sec2_img'] = $sec_corporate_training_sec2_img_path;
            $updatedData['sec_ready_to_empower_workforce_img'] = $sec_ready_to_empower_workforce_img_path;

            $checkData->update($updatedData);

            //store HR Faqs
            $faqs = json_decode($request->faqs);
            HrProfessionalFaq::truncate(); //delete all previous HR Professional faqs

            //store review
            if($faqs){
                $now = \Carbon\Carbon::now();
                $faqs = array_map(function ($faq) use ($now){
                    return [
                        'question' => $faq->question,
                        'answer' => $faq->answer,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];

                }, $faqs);

                HrProfessionalFaq::insert($faqs);
            }

            return sendSuccessResponse('Corporate Training page details updated successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
