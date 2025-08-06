<?php

namespace App\Services;

use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductService{
    // single product find 
    public static function findById($id){
        $blog = Blog::find($id);
        if (!$blog) {
            throw new \Exception('Blog not found', 404);
        }
        return $blog;
    }
    
    // all product find 
    public static function findAll(){
        return Blog::with('user:id,name')->orderBy('created_at', 'desc')->get();
    }
    
    // blog store here 
    public static function storeBlog($request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            throw new \Exception('Validation failed: ' . $validator->errors()->first(), 422);
        }

        $blogData = $request->only(['title', 'content', 'image']);
        $blogData['user_id'] = Auth::id();
        
        return Blog::create($blogData);
    }
    
    //  update blog 
    public static function updateBlog($request, $id){
        $blog = self::findById($id);
        
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'image' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            throw new \Exception('Validation failed: ' . $validator->errors()->first(), 422);
        }
        
        $updateData = $request->only(['title', 'content', 'image']);
        $blog->update($updateData);
        
        return $blog->fresh();
    }
    
    // delete product 
    public static function deleteBlog($id){
        $blog = self::findById($id);
        $blog->delete();
        return ['message' => 'Blog deleted successfully'];
    }
}