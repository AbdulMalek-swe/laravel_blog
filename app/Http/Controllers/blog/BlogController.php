<?php

namespace App\Http\Controllers\blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\User;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;

class BlogController extends Controller
{
    // update controller 
  
    public function show(){
        try {
            $blogContent = ProductService::findAll();
            return response()->json([
                'success' => true,
                'data' => $blogContent,
                'message' => 'Blogs retrieved successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    // find product using id 
    public function singleBlog(string $id){
        try {
            $blogContent = ProductService::findById($id);
            return response()->json([
                'success' => true,
                'data' => $blogContent
            ], 200);
        } catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], $statusCode);
        }
    }
    //   store blog in database 
    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $result = ProductService::storeBlog($request);
            return response()->json([
                'success' => true,
                'message' => 'Blog created successfully',
                'data' => $result,
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], $statusCode);
        }
    }
    // update blog 
    public function update(Request $request, string $id)
    {
        try {
            $result = ProductService::updateBlog($request, $id);
            return response()->json([
                'success' => true,
                'message' => 'Blog updated successfully',
                'data' => $result
            ], 200);
        } catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], $statusCode);
        }
    }
    // delete blog  
    public function destroy(string $id)
    {
        try {
            $result = ProductService::deleteBlog($id);
            return response()->json([
                'success' => true,
                'message' => 'Blog deleted successfully',
                'data' => $result
            ], 200);
        } catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], $statusCode);
        }
    }
}
