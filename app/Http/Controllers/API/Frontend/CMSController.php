<?php

namespace App\Http\Controllers\API\Frontend;

use Validator;
use App\Models\WebsiteFaq;
use App\Models\PageAboutUs;
use Illuminate\Http\Request;
use App\Models\PageContactUs;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\PageTermsAndCondition;
use App\Http\Controllers\API\Exception;

class CMSController extends Controller
{

    public function aboutUsPage(Request $request): JsonResponse
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

    public function termsAndConditionPage(Request $request): JsonResponse
    {
        try {

            $data = PageTermsAndCondition::first();

            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }
            return sendSuccessResponse('Terms and Conditions page details fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function contactUsPage(Request $request): JsonResponse
    {
        try {

            $data = PageContactUs::first();

            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }
            return sendSuccessResponse('Contact Us page details fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function websiteFaq(Request $request): JsonResponse
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
}
