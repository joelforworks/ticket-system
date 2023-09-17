<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Create  a category 
     *
     * @return json 
     */
    public function create(Request $request) {
        // Validate data and throw errors
        $validator = new ValidatorCustom($request);
        $validator->validateCategoryData();

        // Create category
        $category = Category::create([
            'name' => $request->name,
        ]);

        // Return response 
        return response()->json([
            'message' => 'Category created',
            'category' => $category
        ], Response::HTTP_CREATED);

    }
    /**
     * Show  all categories
     *
     * @return json 
     */
    public function show(Request $request){
        $categories = Category::all();

        // Return response 
        return response()->json([
            'succes' => true,
            'categories' => $categories
        ], Response::HTTP_OK);
    }
    /**
     * Find category
     *
     * @return json 
     */
    public function find(Request $request){
        // Validate data and throw errors
        $validator = new ValidatorCustom($request);
        $validator->validateCategory();
        $category = Category::find($request->id);

        // Return response 
        return response()->json([
            'succes' => true,
            'category' => $category
        ], Response::HTTP_OK);
    }
    /**
     * Update category
     *
     * @return json 
     */
    public function update(Request $request){
        // Validate data and throw errors
        $validator = new ValidatorCustom($request);
        $validator->validateCategory();
        $validator->validateUpdateCategoryData();

        // Return response 
        return response()->json([
            'message' => 'Category updated.',
            'category' => Category::find($request->id)
        ], Response::HTTP_CREATED);
    }
    /**
     * Delete category
     *
     * @return json 
     */
    public function delete(Request $request){
        // Validate data and throw errors
        $validator = new ValidatorCustom($request);
        $validator->validateCategory();

        // Delete category
        $category= Category::find($request->id);
        $category->delete();

        // Return response 
        return response()->json([
            'message' => 'Category deleted.',
        ], Response::HTTP_OK);
    }

}
