<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WebsiteFaq;
use App\Http\Controllers\API\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Validator;

class WebsiteFaqController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'question' => 'required',
                'answer' => 'required',
            ]);

            if ($validator->fails()) {
                return sendErrorResponse('Validation Error.', $validator->errors(), 400);
            }

            $storeInfo = WebsiteFaq::create([
                            'question' => $request->question,
                            'answer' => $request->answer,
                        ]);

            return sendSuccessResponse('FAQ inserted successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function listing(Request $request): JsonResponse
    {
        try {

            $data = WebsiteFaq::select('id','question','answer','created_at','updated_at')
                                ->orderBy('id','desc')
                                ->paginate(15);

            return sendSuccessResponse('All FAQs fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function updatedDataFetch(Request $request, $id): JsonResponse
    {
        try {

            $data = WebsiteFaq::select('id','question','answer','created_at','updated_at')
                                ->find($id);

            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }
            return sendSuccessResponse('FAQ data fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'question' => 'required',
                'answer' => 'required',
            ]);

            if ($validator->fails()) {
                return sendErrorResponse('Validation Error.', $validator->errors(), 400);
            }

            $checkData = WebsiteFaq::find($id);

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $storeInfo = WebsiteFaq::where('id', $id)
                                        ->update([
                                            'question' => $request->question,
                                            'answer' => $request->answer,
                                        ]);

            return sendSuccessResponse('FAQ updated successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function destroy(Request $request, $id): JsonResponse
    {
        try {

            $checkData = WebsiteFaq::find($id);

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $checkData->delete();

            return sendSuccessResponse('FAQ deleted successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
