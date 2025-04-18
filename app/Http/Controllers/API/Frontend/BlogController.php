<?php

namespace App\Http\Controllers\API\Frontend;

use Validator;
use App\Models\Blog;
use App\Models\Category;
use App\Models\BlogContact;
use Illuminate\Http\Request;
use App\Models\PageBlogDetail;
use App\Models\PageBlogListing;
use App\Models\SettingManagement;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\SectionLiveFreeDemo;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\Exception;

class BlogController extends Controller
{
    public function listing(Request $request): JsonResponse
    {
        try {

            $category = $request->input('category');  //Filter

            $default_blog_image = SettingManagement::value('default_blog_image');

            $blogs = Blog::with(['categoryDtls:id,name'])
                                ->select(
                                    'id',
                                    'category_id',
                                    'title',
                                    // 'image',
                                    DB::raw("COALESCE(blogs.image, '$default_blog_image') as image"),
                                    'short_content',
                                    'full_content',
                                    'slug',
                                    'mete_title',
                                    'mete_tag',
                                    'meta_description',
                                    'meta_keyword',
                                    'search_tag',
                                    'seo1',
                                    'seo2',
                                    'seo3',
                                    'created_at',
                                    'updated_at'
                                )
                                ->where('status',1)
                                ->orderBy('id','desc');
                                // ->paginate(15);

            if (!is_null($category)) {

                $category = json_decode($category, true);
                if(count($category)){
                    $blogs->whereIn('category_id', $category);
                }
            }

            $blogs = $blogs->paginate(15);

            // // $categoryList = $blogs->pluck('categoryDtls')->unique()->values();
            // $categoryList = $blogs->pluck('categoryDtls');
            // $categoryList = $categoryList->groupBy('id')->map(function($items, $key){
            //     return [
            //         'id'=> $key,
            //         'name'=> $items->first()->name,
            //         'count'=> $items->count(),
            //     ];
            // })->values();

            $categoryList = Category::select('id','name')
            ->whereHas('blogs', function ($query) {
                $query->where('status', 1);
            })
            ->withCount(['blogs as count' => function ($query) {
                $query->where('status', 1);
            }])
            ->get();

            $data['blogs'] = $blogs;
            // $data['categoryList'] = $categoryList;
            $data['categoryList'] = $categoryList;
            $data['pageContent'] = PageBlogListing::first();
            $data['SectionLiveFreeDemo'] = SectionLiveFreeDemo::first();

            return sendSuccessResponse('All blogs fetched successfully.', $data);

        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function details(Request $request, $slug): JsonResponse
    {
        try {

            $default_blog_image = SettingManagement::value('default_blog_image');

            $blogDetails = Blog::with(['categoryDtls:id,name'])
                                ->select(
                                    'id',
                                    'category_id',
                                    'title',
                                    'image',
                                    DB::raw("COALESCE(blogs.image, '$default_blog_image') as image"),
                                    'short_content',
                                    'full_content',
                                    'slug',
                                    'mete_title',
                                    'mete_tag',
                                    'meta_description',
                                    'meta_keyword',
                                    'search_tag',
                                    'seo1',
                                    'seo2',
                                    'seo3',
                                    'created_at',
                                    'updated_at'
                                )
                                ->where('slug', $slug)
                                ->first();

            if (!$blogDetails) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $data['blogDetails'] = $blogDetails;
            $data['pageContent'] = PageBlogDetail::first();
            $data['SectionLiveFreeDemo'] = SectionLiveFreeDemo::first();

            return sendSuccessResponse('Blog details fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function blogContact(Request $request): JsonResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'blog_id' => 'required',
                'student_name' => 'required',
                'student_email' => 'required',
                'phone' => 'required',
            ]);

            if ($validator->fails()) {
                return sendErrorResponse('Validation Error.', $validator->errors(), 400);
            }

            $storeInfo = BlogContact::create([
                            'blog_id' => $request->blog_id,
                            'student_name' => $request->student_name,
                            'student_email' => $request->student_email,
                            'calling_code' => $request->calling_code,
                            'phone' => $request->phone,
                            'message' => $request->message,
                        ]);

            return sendSuccessResponse('Message sent successfully!', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
