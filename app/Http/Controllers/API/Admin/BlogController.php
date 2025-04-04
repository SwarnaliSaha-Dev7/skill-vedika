<?php

namespace App\Http\Controllers\API\Admin;

use Validator;
use App\Models\Blog;
use App\Models\BlogContact;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\API\Exception;

class BlogController extends Controller
{
    function generateSlug($title, $table, $id)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;

        // Ensure the slug is unique in the table
        // $count = 1;
        // while (DB::table($table)->where('slug', $slug)->exists()) {
        //     $slug = $originalSlug . '-' . $id;
        //     $count++;
        // }

        // if($table::where('slug', $slug)->exists()){
        if(Blog::where('slug', $slug)->exists()){
            $count = $id; //$id is generated random no
            $slug = $originalSlug . '-' . $count;

            // while (Blog::where('slug', $slug)->exists()) {
            //     $count++;
            //     $slug = $originalSlug . '-' . $count;
            // }
        }

        return $slug;
    }

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

    public function add(Request $request): JsonResponse
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'category_id' => 'required|integer',
                    'title' => 'required'
                ]
            );

            if ($validator->fails()) {
                return sendErrorResponse('Validation Error.', $validator->errors(), 400);
            }

            // Save new file
            $path = public_path('uploads/blog');
            // if (!file_exists($path)) {
            //     mkdir($path, 0777, true);
            // }
            //save image
            $fileName = null;
            $filePath = null;
            if ($request->hasFile('image')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('image')->getClientOriginalName();
                $request->image->move($path, $fileName);
                $filePath = "uploads/blog/" . $fileName;
            }


            $randNo = rand(1000, 9999);
            $slug = $this->generateSlug($request->title, 'Blog', $randNo);

            $insertedData = [
                'category_id' => $request->category_id,
                'title' => $request->title,
                'image' => $filePath,
                'short_content' => $request->short_content,
                'full_content' => $request->full_content,
                // 'status' => $request->status,
                'mete_title' => $request->mete_title,
                'mete_tag' => $request->mete_tag,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword,
                'search_tag' => $request->search_tag,
                'seo1' => $request->seo1,
                'seo2' => $request->seo2,
                'seo3' => $request->seo3,
                'slug' => $slug,
            ];

            $storeInfo = Blog::create($insertedData);
            $blog_id = $storeInfo->id;

            return sendSuccessResponse('Blog added successfully.', $blog_id);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function listing(Request $request): JsonResponse
    {
        try {

            $blogs = Blog::with(['categoryDtls:id,name'])
                                ->select(
                                    'id',
                                    'category_id',
                                    'title',
                                    'image',
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
                                ->orderBy('id','desc')
                                ->paginate(15);

            return sendSuccessResponse('All blogs fetched successfully.', $blogs);

        } catch (\Throwable $th) {
            // Log::error('All courses fetched error: ' . $th->getMessage());
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function updatedDataFetch(Request $request, $id): JsonResponse
    {
        try {

            $data = Blog::select(
                                'id',
                                'category_id',
                                'title',
                                'image',
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
                            ->find($id);

            if (!$data) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            return sendSuccessResponse('Blog details fetched successfully.', $data);
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'category_id' => 'required|integer',
                'title' => 'required'
            ]);

            if ($validator->fails()) {
                return sendErrorResponse('Validation Error.', $validator->errors(), 400);
            }

            $blogData = Blog::find($id);

            if (!$blogData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            $slug = $blogData->slug;
            if ($blogData->title != $request->title) {
                $randNo = rand(1000, 9999);
                $slug = $this->generateSlug($request->title, 'Blog', $randNo);
            }

            // Save new file
            $path = public_path('uploads/blog');
            // if (!file_exists($path)) {
            //     mkdir($path, 0777, true);
            // }

            $fileName = null;
            $filePath = null;
            if ($request->hasFile('image')) {
                $fileName = time() . rand(1000, 9999) . "_" . $request->file('image')->getClientOriginalName();
                $request->image->move($path, $fileName);
                $filePath = "uploads/blog/" . $fileName;

                if ($blogData->image) {
                    $this->delete_file($blogData->image);
                }
            } else {
                if($request->image){
                    $filePath = $blogData->image;
                }
                // else{
                //     $filePath = null;
                // }
            }


            $updatedData = [
                'category_id' => $request->category_id,
                'title' => $request->title,
                'image' => $filePath,
                'short_content' => $request->short_content,
                'full_content' => $request->full_content,
                // 'status' => $request->status,
                'mete_title' => $request->mete_title,
                'mete_tag' => $request->mete_tag,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword,
                'search_tag' => $request->search_tag,
                'seo1' => $request->seo1,
                'seo2' => $request->seo2,
                'seo3' => $request->seo3,
                'slug' => $slug,
            ];

            $storeInfo = Blog::where('id', $id)->update($updatedData);

            return sendSuccessResponse('Blog updated successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function destroy(Request $request, $id): JsonResponse
    {
        try {

            $checkData = Blog::find($id);

            if (!$checkData) {
                return sendErrorResponse('Data not found.', '', 404);
            }

            if ($checkData->image) {
                $this->delete_file($checkData->image);
            }

            $checkData->delete();

            return sendSuccessResponse('Blog details deleted successfully.', '');
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function studentContactList(Request $request): JsonResponse
    {
        try {

            $list = BlogContact::
                with([
                'blogDtls:id,title,category_id',
                'blogDtls.categoryDtls:id,name',
                ])
            ->orderBy('id','desc')
            ->paginate(15);

            return sendSuccessResponse('All contacts fetched successfully.', $list);

        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }
}
