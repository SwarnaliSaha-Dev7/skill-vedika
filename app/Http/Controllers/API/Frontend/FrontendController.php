<?php

namespace App\Http\Controllers\API\Frontend;

use Validator;
use App\Models\Skill;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\API\Exception;

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

    public function courseListing(Request $request): JsonResponse
    {
        try {

            $courses = Course::select('id', 'course_name')
                            ->where('status', 1)
                            ->orderBy('id','desc')
                            ->get();

            return sendSuccessResponse('All courses fetched successfully.', $courses);

        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function becomeAnInstructorContact(Request $request): JsonResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'course_name' => 'required',
                // 'is_terms_and_condition_checked_by_student' => 'required',
            ]);

            if ($validator->fails()) {
                return sendErrorResponse('Validation Error.', $validator->errors(), 400);
            }

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => "+".$request->calling_code." ".$request->phone,
                "course_name" => $request->course_name,
                "message" => $request->message,
                "date" => \Carbon\Carbon::now()->toDateString(),
            ];

            // Send email to Admin
            $adminEmail = env('ADMIN_MAIL');
            Mail::send('email.frontend.becomeAnInstructorContactNotification', $data, function ($message) use ($adminEmail) {
                $message->to($adminEmail) // Use the recipient's email
                    ->subject('New Instructor Application Submition Alert on Skill Vedika');
                $message->from(env('MAIL_FROM_ADDRESS'), "Skill Vedika");
            });

            return sendSuccessResponse('Message sent successfully!', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
