<?php

namespace Modules\Category\Http\Controllers;

// use Modules\Category\Helpers\ApiResponse;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Category\Entities\Category;
use Modules\Category\Http\Requests\CategoryCreate;
use Modules\Category\Transformers\CategoryResource;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = DB::table('categories')->select('*')->get();
        return ApiResponse::sendResponse('200', 'All Categories', CategoryResource::collection($categories));
        
    }



    public function store(CategoryCreate $request)
    {
        $data=$request->validated();
        Category::create($data);
        return ApiResponse::sendResponse('201','Created Successfuly',[]);
    }


    public function show($id)
    {

        //
    }




    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
