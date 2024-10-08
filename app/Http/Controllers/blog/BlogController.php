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
  
    public function show( ){
           $blogContent =   ProductService::findAll();
           return response()->json($blogContent);
    }
    // find product using id 
    public function singleBlog(string $id){
           $blogContent =   ProductService::findById($id);
         
           return response()->json($blogContent);
    }
    //   store blog in database 
    public function store(Request $request)
    {
       try {
         $user = Auth::user();
        $result =  ProductService::storeBlog($request);
        return  response()->json([
         "message"=>"successfully create blog ",
         "result"=>$result,
         "user"=>$user
        ],201);
       } catch (\Throwable $th) {
        //throw $th;
        return  "succesfully image upload" .$th->getMessage() ;
       }
    }
    // update blog 
    public function update(Request $request,string $id)
    {
       try {
        $result =  ProductService::updateBlog($request, $id);
        return  response()->json([
         "message"=>"successfully create blog ",
         "result"=>$result
        ],201);
       } catch (\Throwable $th) {
        //throw $th;
        return  "succesfully image upload" .$th->getMessage() ;
       }
    }
    // delete blog  
    public function destroy( string $id)
    {
       try {
        $result =  ProductService::deleteBlog($id);
        return  response()->json([
         "message"=>"successfully create blog ",
         "result"=>$result
        ],201);
       } catch (\Throwable $th) {
        //throw $th;
        return  "succesfully image upload" .$th->getMessage() ;
       }
    }
}
