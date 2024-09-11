<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Category\Models\Category;
use Modules\Category\Traits\GeneralTrait;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Modules\Category\Http\Requests\CategoryRequest;
use Modules\Category\Traits\MiddlewareTrait;

class CategoryController extends Controller implements HasMiddleware
{
    use GeneralTrait,MiddlewareTrait;
    //============================================================================
    public static function middleware(): array{
        return self::checkMiddlewareApply();
    }
    //============================================================================
    public function index(){
        $categories  = Category::latest()->get();
        return view('category::admin.index', compact('categories'));
    }
    //============================================================================
    public function create(){
        return view('category::admin.create');
    }
    //============================================================================
    public function store(CategoryRequest $request){
        try{
            Category::create($this->handleCategoryRequest($request));
            return redirect()->route('admin.categories.index')->with('success', trans('category::main.form.add_done'));
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
    //============================================================================
    public function show(Category $category){
        //
    }
    //============================================================================
    public function edit($category){
        return view('category::admin.edit', compact('category'));
    }
    //============================================================================
    public function update(CategoryRequest $request, Category $category){
        try{
            $category->update($this->handleCategoryRequest($request));
            return redirect()->route('admin.categories.index')->with('success', trans('category::main.form.update_done'));
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
    //============================================================================
    public function destroy(Category $category){
        //TODO, we will handle this later
        // if (count($category->products)) {
        //     return redirect()->back()->with('error', 'لا يمكن حذف هذا القسم لوجود منتجات بداخله');
        // } else {
        //     $category->delete();
        //     return redirect()->route('admin.categories.index')->with('success', trans('category::main.form.delete_done'));
        // }
    }
}
