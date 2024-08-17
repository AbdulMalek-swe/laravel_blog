<?php

namespace App\Services;

use App\Models\Blog;
class ProductService{
    // single product find 
    public static function findById($id){
        return Blog::find($id);
    }
    // all product find 
    public static function findAll(){
        return Blog::all();
    }
    // blog store here 
    public static function storeBlog($request){
        return Blog::create($request->all());
    }
    //  update blog 
    public static function updateBlog(){
        
        return "successfully update blog";
    }
}