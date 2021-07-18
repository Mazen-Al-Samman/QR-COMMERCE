<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Media;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category();
        $categories = $category->getAllCategories();
        $vendors = Vendor::getAllVendors();
        return view('backend.category.create', [
            'category' => $category,
            'vendors' => $vendors,
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'vendor' => ['required', 'exists:vendors,id'],
            'image' => ['required', 'file', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048'],
        ]);

        if ($validation->fails()) {
            return Redirect::route('category.create')->withErrors($validation);
        }

        $category = new Category();
        if ($category->createCategory($request)) {
            $request->session()->flash('success', 'Category was successful added!');
            return \redirect()->route('category.create');
        }

        return new \Exception('an error occurred');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);

        return view('backend.category.view', [
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $vendors = Vendor::getAllVendors();
        return view('backend.category.edit', [
            'category' => $category,
            'vendors' => $vendors
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'vendor' => ['required', 'exists:vendors,id'],
            'image' => ['file', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048'],
        ]);

        if ($validation->fails()) {
            return Redirect::route('category.create')->withErrors($validation);
        }

        $category = new Category();
        if ($category->updateCategory($id, $request)) {
            $request->session()->flash('alert-update', 'Category was successful updated!');
            return Redirect::back();
        }

        return new \Exception('an error occurred');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if (Category::find($id)->delete()) {
            $request->session()->flash('alert-delete', 'Category was successful deleted!');
            return \redirect()->route('category.create');
        }
    }

    public function categoriesApi(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
            $vendor_id = $request->vendor_id ? $request->vendor_id : null;
            $category = new Category();
            $categories = $category->getCategoriesApi($vendor_id);
            return response()->json([
                'status' => true,
                'data' => $categories
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ]);
        }
    }

}
