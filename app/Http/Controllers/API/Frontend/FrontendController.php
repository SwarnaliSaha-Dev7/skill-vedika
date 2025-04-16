<?php

namespace App\Http\Controllers\API\Frontend;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\Exception;
use App\Models\Skill;

class FrontendController extends Controller
{
    public function skillListing(Request $request): JsonResponse
    {
        try {
            $data = Skill::select('id as value', 'name as label')->get();

            // DB::table('skills')
            //         ->select('id as value', 'name as label');

            return sendSuccessResponse('Skills fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
