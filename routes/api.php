<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Admin\UserController;
use App\Http\Controllers\API\Admin\AdminController;
use App\Http\Controllers\API\Admin\SkillController;
use App\Http\Controllers\API\Frontend\CMSController;
use App\Http\Controllers\API\Frontend\BlogController;
use App\Http\Controllers\API\Admin\CategoryController;
use App\Http\Controllers\API\Admin\PageHomeController;
use App\Http\Controllers\API\Admin\CourseFaqController;
use App\Http\Controllers\API\Frontend\CourseController;
use App\Http\Controllers\API\Admin\PopularTagController;
use App\Http\Controllers\API\Admin\WebsiteFaqController;
use App\Http\Controllers\API\Admin\PageAboutUsController;
use App\Http\Controllers\API\Frontend\FrontendController;
use App\Http\Controllers\API\Admin\CourseReviewController;
use App\Http\Controllers\API\Admin\PageContactUsController;
use App\Http\Controllers\API\Admin\SeoManagementController;
use App\Http\Controllers\API\Admin\AdminDashboardController;
use App\Http\Controllers\API\Admin\PageBlogDetailController;
use App\Http\Controllers\API\Admin\PageBlogListingController;
use App\Http\Controllers\API\Admin\PageOnJobSupportController;
use App\Http\Controllers\API\Admin\SectionKeyFeatureController;
use App\Http\Controllers\API\Admin\SettingManagementController;


use App\Http\Controllers\API\Admin\SectionForCorporateController;
use App\Http\Controllers\API\Admin\SectionLiveFreeDemoController;
use App\Http\Controllers\API\Admin\PageBecomeInstructorsController;
use App\Http\Controllers\API\Admin\PageCorporateTrainingController;
use App\Http\Controllers\API\Admin\PageTermsAndConditionController;
use App\Http\Controllers\API\Admin\PageCourseSearchResultController;
use App\Http\Controllers\API\Admin\SectionJobProgramSupportController;
use App\Http\Controllers\API\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\API\Admin\SectionJobAssistanceProgramController;
use App\Http\Controllers\API\Admin\CourseController as AdminCourseController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', function () {
    return "APIS caught from SkillVedika";
});

//=================== Course =========================
Route::get('/course/listing', [CourseController::class, 'listing']);
Route::get('/course/details/{slug}', [CourseController::class, 'details']);
Route::post('/course/contact', [CourseController::class, 'courseContact']);

//=================== Blog =========================
Route::get('/blog/listing', [BlogController::class, 'listing']);
Route::get('/blog/details/{slug}', [BlogController::class, 'details']);
Route::post('/blog/contact', [BlogController::class, 'blogContact']);

//=================== Content Pages =========================
Route::get('/page/home-page', [CMSController::class, 'homePage']);
Route::get('/page/about-us', [CMSController::class, 'aboutUsPage']);
Route::get('/page/terms-and-condition', [CMSController::class, 'termsAndConditionPage']);
Route::get('/page/contact-us', [CMSController::class, 'contactUsPage']);
Route::get('/page/become-instructor', [CMSController::class, 'becomeInstructorPage']);
Route::get('/page/corporate-training', [CMSController::class, 'corporateTrainingPage']);
Route::get('/page/on-job-support', [CMSController::class, 'onJobSupportPage']);
Route::get('/page/settings-data', [CMSController::class, 'settingsData']);
Route::get('/faqs', [CMSController::class, 'websiteFaq']);

//=================== SEO Data of Page =========================
Route::get('/seo-data-of-page/{type}', [CMSController::class, 'seoDataOfPage']);

// Become an Instructor Contact
Route::post('/become-an-instructor/contact', [FrontendController::class, 'becomeAnInstructorContact']);

// Fetch Skills
Route::get('/skill/listing', [FrontendController::class, 'skillListing']);

// Fetch Course list(only id,name)
Route::get('/course-listing', [FrontendController::class, 'courseListing']);



Route::prefix('admin')->group(function () {
    Route::post('/login', [UserController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout', [UserController::class, 'logout']);
        Route::post('change-profile', [UserController::class, 'changeAdminProfileData']);

        //==== Category ====
        Route::post('/category/add', [CategoryController::class, 'store']);
        Route::get('/category/listing', [CategoryController::class, 'listing']);
        Route::get('/category/update/{id}', [CategoryController::class, 'updatedDataFetch']);
        Route::post('/category/update/{id}', [CategoryController::class, 'update']);
        Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy']);


        //==== Skill ====
        Route::post('/skill/add', [SkillController::class, 'store']);
        Route::get('/skill/listing', [SkillController::class, 'listing']);
        Route::get('/skill/update/{id}', [SkillController::class, 'updatedDataFetch']);
        Route::post('/skill/update/{id}', [SkillController::class, 'update']);
        Route::delete('/skill/delete/{id}', [SkillController::class, 'destroy']);

        //=================== Course =========================
        Route::post('/course/add', [AdminCourseController::class, 'add']);
        Route::post('/course/curriculum/image/upload', [AdminCourseController::class, 'uploadCourseCurriculumImage']);
        Route::get('/course/listing', [AdminCourseController::class, 'listing']);
        Route::get('/course/update/{id}', [AdminCourseController::class, 'updatedDataFetch']);
        Route::post('/course/update/{id}', [AdminCourseController::class, 'update']);
        Route::delete('/course/delete/{id}', [AdminCourseController::class, 'destroy']);

        //=================== Course Contact=========================
        Route::get('/course/student-contact/listing', [AdminCourseController::class, 'studentContactList']);
        Route::get('/course/student-contact/view/{id}', [AdminCourseController::class, 'studentContactView']);
        Route::delete('/course/student-contact/delete/{id}', [AdminCourseController::class, 'studentContactDestroy']);
        Route::post('/course/student-contact/bulk-delete', [AdminCourseController::class, 'studentContactBulkDestroy']);

        //=================== Course Reviews =========================
        Route::post('/course/review/add', [CourseReviewController::class, 'store']);
        Route::get('/course/review/listing', [CourseReviewController::class, 'listing']);
        Route::get('/course/review/update/{course_id}', [CourseReviewController::class, 'updatedDataFetch']);
        Route::post('/course/review/update/{course_id}', [CourseReviewController::class, 'update']);
        Route::delete('/course/review/delete/{course_id}', [CourseReviewController::class, 'destroy']);

        //=================== Course FAQ =========================
        Route::post('/course/faq/add', [CourseFaqController::class, 'store']);
        Route::get('/course/faq/listing', [CourseFaqController::class, 'listing']);
        Route::get('/course/faq/update/{course_id}', [CourseFaqController::class, 'updatedDataFetch']);
        Route::post('/course/faq/update/{course_id}', [CourseFaqController::class, 'update']);
        Route::delete('/course/faq/delete/{course_id}', [CourseFaqController::class, 'destroy']);


        //=================== Blog =========================
        Route::post('/blog/add', [AdminBlogController::class, 'add']);
        Route::get('/blog/listing', [AdminBlogController::class, 'listing']);
        Route::get('/blog/update/{id}', [AdminBlogController::class, 'updatedDataFetch']);
        Route::post('/blog/update/{id}', [AdminBlogController::class, 'update']);
        Route::delete('/blog/delete/{id}', [AdminBlogController::class, 'destroy']);
        Route::get('/blog/student-contact/listing', [AdminBlogController::class, 'studentContactList']);

        //=================== Website FAQ =========================
        Route::post('/faq/add', [WebsiteFaqController::class, 'store']);
        Route::get('/faq/listing', [WebsiteFaqController::class, 'listing']);
        Route::get('/faq/update/{id}', [WebsiteFaqController::class, 'updatedDataFetch']);
        Route::post('/faq/update/{id}', [WebsiteFaqController::class, 'update']);
        Route::delete('/faq/delete/{id}', [WebsiteFaqController::class, 'destroy']);

        //=================== Popular Tag =========================
        Route::post('/popular_tag/add', [PopularTagController::class, 'store']);
        Route::get('/popular_tag/listing', [PopularTagController::class, 'listing']);
        Route::get('/popular_tag/update/{id}', [PopularTagController::class, 'updatedDataFetch']);
        Route::post('/popular_tag/update/{id}', [PopularTagController::class, 'update']);
        Route::delete('/popular_tag/delete/{id}', [PopularTagController::class, 'destroy']);

        //=================== Admin Dashboard Page =========================
        Route::get('/dashboard', [AdminDashboardController::class, 'adminDashboard']);

        //=================== About Us Page =========================
        Route::get('page/about-us/details', [PageAboutUsController::class, 'updatedDataFetch']);
        Route::post('page/about-us/details/update', [PageAboutUsController::class, 'update']);

         //=================== Terms & Conditions Page =========================
         Route::get('page/terms-and-condition/details', [PageTermsAndConditionController::class, 'updatedDataFetch']);
         Route::post('page/terms-and-condition/details/update', [PageTermsAndConditionController::class, 'update']);

        //=================== Contact Us Page =========================
        Route::get('page/contact-us/details', [PageContactUsController::class, 'updatedDataFetch']);
        Route::post('page/contact-us/details/update', [PageContactUsController::class, 'update']);

        //=================== Corporate Training Page =========================
        Route::get('page/corporate-training/details', [PageCorporateTrainingController::class, 'updatedDataFetch']);
        Route::post('page/corporate-training/details/update', [PageCorporateTrainingController::class, 'update']);

        //=================== On Job Support Page =========================
        Route::get('page/on-job-support/details', [PageOnJobSupportController::class, 'updatedDataFetch']);
        Route::post('page/on-job-support/details/update', [PageOnJobSupportController::class, 'update']);

        //=================== Course Listing Page =========================
        Route::get('page/course-listing/details', [PageCourseSearchResultController::class, 'updatedDataFetch']);
        Route::post('page/course-listing/details/update', [PageCourseSearchResultController::class, 'update']);

        //=================== Home Page =========================
        Route::get('page/home/details', [PageHomeController::class, 'updatedDataFetch']);
        Route::post('page/home/details/update', [PageHomeController::class, 'update']);

        //=================== Blog Listing Page =========================
        Route::get('page/blog-listing/details', [PageBlogListingController::class, 'updatedDataFetch']);
        Route::post('page/blog-listing/details/update', [PageBlogListingController::class, 'update']);

        //=================== Blog Detail Page =========================
        Route::get('page/blog-detail/details', [PageBlogDetailController::class, 'updatedDataFetch']);
        Route::post('page/blog-detail/details/update', [PageBlogDetailController::class, 'update']);

        //=================== Blog Detail Page =========================
        Route::get('page/become-instructor/details', [PageBecomeInstructorsController::class, 'updatedDataFetch']);
        Route::post('page/become-instructor/details/update', [PageBecomeInstructorsController::class, 'update']);

        //=================== Section For Corporates =========================
        Route::get('section/for-corporates/details', [SectionForCorporateController::class, 'updatedDataFetch']);
        Route::post('section/for-corporates/details/update', [SectionForCorporateController::class, 'update']);

        //=================== Section Job Program Support =========================
        Route::get('section/job-program-support/details', [SectionJobProgramSupportController::class, 'updatedDataFetch']);
        Route::post('section/job-program-support/details/update', [SectionJobProgramSupportController::class, 'update']);

        //=================== Section Live Free Demo =========================
        Route::get('section/live-free-demo/details', [SectionLiveFreeDemoController::class, 'updatedDataFetch']);
        Route::post('section/live-free-demo/details/update', [SectionLiveFreeDemoController::class, 'update']);

        //=================== Section Key Feature =========================
        Route::get('section/key-feature/details', [SectionKeyFeatureController::class, 'updatedDataFetch']);
        Route::post('section/key-feature/details/update', [SectionKeyFeatureController::class, 'update']);

        //=================== Section Section Job Assistance Program =========================
        Route::get('section/job-assistance-program/details', [SectionJobAssistanceProgramController::class, 'updatedDataFetch']);
        Route::post('section/job-assistance-program/details/update', [SectionJobAssistanceProgramController::class, 'update']);

        //=================== Settigns Manage =========================
        Route::get('setting/details', [SettingManagementController::class, 'updatedDataFetch']);
        Route::post('setting/details/update', [SettingManagementController::class, 'update']);

        //=================== Settigns Manage =========================
        Route::get('/seo/listing', [SeoManagementController::class, 'listing']);
        Route::get('/seo/update/{type}', [SeoManagementController::class, 'updatedDataFetch']);
        Route::post('/seo/update/{type}', [SeoManagementController::class, 'update']);

        //fetch course list(only id,name)
        Route::get('/course-listing', [AdminController::class, 'courseListing']);
    });
});


//====== Handle Undefined URL ========
Route::fallback(function () {
    return response()->json([
        'status' => false,
        'message' => 'Endpoint not found. Please check the URL or HTTP method.'
    ], 404);
});
