<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::Selection()->latest()->paginate(12);
        return view('pages.categories.index',compact('categories'));
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->latest()->paginate(12);
        return view('pages.categories.trash', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddCategoryRequest $request)
    {
        try {
            Category::create([
                'title' => $request->title,
                'created_by' => (Auth::user()->id),
            ]);

            session()->flash('Store','Added successfully');
            return redirect()->route('categories');

        } catch (\Exception $ex) {

            session()->flash('error','Something went wrong, please try again');
            return redirect()->back()->withErrors(['error' => $ex->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::selection()->find($id) ?? Category::onlyTrashed()->find($id);

        if(! $category){
            session()->flash('error','There is no item with this id');
            return redirect()->back();
        }

        $movies = Movie::selection()->where('category_id', $id)->get();
        return view('pages.categories.show', compact('movies', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        try {
            $category = Category::selection()->find($request->id);

            if(! $category){
                session()->flash('error','There is no item with this id');
                return redirect()->back();
            }


            $category->update($request->all());

            session()->flash('Update','Updated successfully');
            return redirect()->route('categories');

        } catch (\Exception $ex) {
            session()->flash('error','Something went wrong, please try again');
            return redirect()->back()->withErrors(['error' => $ex->getMessage()]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {

            $category = Category::withTrashed()->find($request->id);

            if(! $category){
                session()->flash('error','There is no item with this id');
                return redirect()->back();
            }



            $category->forceDelete();

            session()->flash('Destroy','Deleted successfully');
            return redirect()->route('categories.trash');

        }catch (\Exception $ex) {
            session()->flash('error','Something went wrong, please try again');
            return redirect()->back()->withErrors(['error' => $ex->getMessage()]);
        }
    }

    public function softDelete($id)
    {
        try {

            $category = Category::selection()->find($id);

            if(! $category){
                session()->flash('error','There is no item with this id');
                return redirect()->back();
            }

            $category->delete();

            session()->flash('SoftDelete','Archive successfully');
            return redirect()->route('categories');

        }catch (\Exception $ex) {
            session()->flash('error','Something went wrong, please try again');
            return redirect()->back()->withErrors(['error' => $ex->getMessage()]);
        }
    }

    public function restore($id)
    {
        try {

            $category = Category::withTrashed()->find($id);

            if(! $category){
                session()->flash('error','There is no item with this id');
                return redirect()->back();
            }

            $category->restore();

            session()->flash('Restore','Recovery completed successfully');
            return redirect()->route('categories');

       }catch (\Exception $ex) {
            session()->flash('error','Something went wrong, please try again');
            return redirect()->back()->withErrors(['error' => $ex->getMessage()]);
       }

    }



}
