<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SeoManagement;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\API\Exception;
use Validator;

class SeoManagementController extends Controller
{
    public function listing(Request $request): JsonResponse
    {
        try {

            $data = SeoManagement::paginate(15);

            return sendSuccessResponse('All SEO data fetch successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function updatedDataFetch(Request $request, $type): JsonResponse
    {
        try {

            $data = SeoManagement::
                            where('page_type', $type)
                            ->first();

            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }
            return sendSuccessResponse('SEO data fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function update(Request $request, $type): JsonResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'page' => 'required',
            ]);

            if ($validator->fails()) {
                return sendErrorResponse('Validation Error.', $validator->errors(), 400);
            }

            $checkData = SeoManagement::
                        where('page_type', $type)
                        ->first();

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $updatedData = [
                'page' => $request->page,
                'site_url' => $request->site_url,
                'mete_title' => $request->mete_title,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword,
            ];

            $storeInfo = SeoManagement::where('page_type', $type)
                                        ->update($updatedData);

            return sendSuccessResponse('SEO details updated successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
