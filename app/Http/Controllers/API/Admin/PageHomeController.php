<?php

namespace App\Http\Controllers\API\Admin;

use Validator;
use App\Models\PageHome;
use Illuminate\Http\Request;
use App\Models\WebsiteReview;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\API\Exception;

class PageHomeController extends Controller
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

            $PageHomeData = PageHome::first();

            if (!$PageHomeData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $reviews = WebsiteReview::select('id','review','created_at','updated_at')
                                    ->get();

            $data['homePageData'] = $PageHomeData;
            $data['reviews'] = $reviews;

            return sendSuccessResponse('Home page details fetched successfully.', $data);
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

            $checkData = PageHome::first();

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $path = public_path('uploads/CMS');
            // if (!file_exists($path)) {
            //     mkdir($path, 0777, true);
            // }

            //img1 upload
            $fileName = null;
            $img1_path = null;
            if ($request->hasFile('img1')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('img1')->getClientOriginalName();
                $request->img1->move($path, $fileName);
                $img1_path = "uploads/CMS/" . $fileName;

                if ($checkData->img1) {
                    $this->delete_file($checkData->img1);
                }
            } else {
                if($request->img1){
                    $img1_path = $request->img1;
                    // $img1_path = $checkData->img1;
                }
                // else{
                //     $img1_path = null;
                // }
            }

            //start_building_your_carrer_img upload
            $fileName = null;
            $start_building_your_carrer_img_path = null;
            if ($request->hasFile('start_building_your_carrer_img')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('start_building_your_carrer_img')->getClientOriginalName();
                $request->start_building_your_carrer_img->move($path, $fileName);
                $start_building_your_carrer_img_path = "uploads/CMS/" . $fileName;

                if ($checkData->start_building_your_carrer_img) {
                    $this->delete_file($checkData->start_building_your_carrer_img);
                }
            } else {
                if($request->start_building_your_carrer_img){
                    $start_building_your_carrer_img_path = $request->start_building_your_carrer_img;
                    // $start_building_your_carrer_img_path = $checkData->start_building_your_carrer_img;
                }
                // else{
                //     $start_building_your_carrer_img_path = null;
                // }
            }


            $updatedData = [
                'title1' => $request->title1,
                'desc1' => $request->desc1,
                'img1' => $img1_path,
                'title2' => $request->title2,
                'desc2' => $request->desc2,
                'start_building_your_carrer_title' => $request->start_building_your_carrer_title,
                'start_building_your_carrer_img' => $start_building_your_carrer_img_path,
                'blog_list_title' => $request->blog_list_title,
                'review_heading' => $request->review_heading,
            ];

            $checkData->update($updatedData);

            //store reviews
            $reviews = json_decode($request->reviews);

            //delete all previous reviews
            WebsiteReview::truncate();

            //store review
            if($reviews){
                $now = \Carbon\Carbon::now();
                $reviews = array_map(function ($text) use ($now){
                    return [
                        'review' => $text,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];

                }, $reviews);

                WebsiteReview::insert($reviews);
            }

            return sendSuccessResponse('Home page details updated successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
