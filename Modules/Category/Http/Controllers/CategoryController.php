<?php

namespace Modules\Category\Http\Controllers;

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
        $categories = DB::select('select * from categories');
        $data=CategoryResource::collection($categories);
        return ApiResponse::sendResponse($data, 'All Categories Retrived');
    }



    public function store(CategoryCreate $request)
    {
        $data = $request->validated();
        Category::create($data);
        return ApiResponse::sendResponse([], 'Created Sucessfuly', 201);
    }


    public function show(Request $request)
    {
        $searchParam = $request->input('searchparam');
        $category = DB::table('categories')
        ->select('id', 'name')
        ->where('name', 'LIKE', "%$searchParam%")
        ->get();
        if (count($category) > 0) {
            return ApiResponse::sendResponse($category, 'Category Found');
        }
        return ApiResponse::sendResponse([], 'Not Found', 404);
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