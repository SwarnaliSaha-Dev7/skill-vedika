<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PopularTag;
use App\Http\Controllers\API\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Validator;

class PopularTagController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'tag' => 'required',
            ]);

            if ($validator->fails()) {
                return sendErrorResponse('Validation Error.', $validator->errors(), 400);
            }

            $storeInfo = PopularTag::create([
                            'tag' => $request->tag,
                        ]);

            return sendSuccessResponse('Tag inserted successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function listing(Request $request): JsonResponse
    {
        try {

            $data = PopularTag::orderBy('id','desc')
                                ->paginate(15);

            return sendSuccessResponse('All Tags fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function updatedDataFetch(Request $request, $id): JsonResponse
    {
        try {

            $data = PopularTag::find($id);

            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }
            return sendSuccessResponse('Tag data fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'tag' => 'required'
            ]);

            if ($validator->fails()) {
                return sendErrorResponse('Validation Error.', $validator->errors(), 400);
            }

            $checkData = PopularTag::find($id);

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $storeInfo = PopularTag::where('id', $id)
                                        ->update([
                                            'tag' => $request->tag
                                        ]);

            return sendSuccessResponse('Tag updated successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function destroy(Request $request, $id): JsonResponse
    {
        try {

            $checkData = PopularTag::find($id);

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $checkData->delete();

            return sendSuccessResponse('Tag deleted successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
