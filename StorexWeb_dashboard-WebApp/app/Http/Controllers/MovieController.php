<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Traits\UploadImageTrait;

class MovieController extends Controller
{
    use UploadImageTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::Selection()->latest()->paginate(12);
        $categories = Category::Selection()->orderby('title')->get();
        return view('pages.movies.index',compact('movies', 'categories'));
    }

    public function trash()
    {
        $movies = Movie::onlyTrashed()->latest()->paginate(12);
        $categories = Category::Selection()->orderby('title')->get();
        return view('pages.movies.trash', compact('movies', 'categories'));
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
    public function store(AddMovieRequest $request)
    {
        try {

            $image_path = $this->uploadImage($request, 'image' ,'movies');

            Movie::create([
                'title' => $request->title,
                'description' => $request->description,
                // 'rate' => $request->rate,
                'image' => $image_path,
                'category_id' => $request->category_id,
                'created_by' => (Auth::user()->id),
            ]);

            session()->flash('Store','Added successfully');
            return redirect()->route('movies');

        } catch (\Exception $ex) {

            session()->flash('error','Something went wrong, please try again');
            return redirect()->back()->withErrors(['error' => $ex->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Movie::selection()->find($id) ?? Category::onlyTrashed()->find($id);

        if(! $movie){
            session()->flash('error','There is no item with this id');
            return redirect()->back();
        }

        return view('pages.movies.show', compact('movie'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMovieRequest $request)
    {
        try {
            $movie = Movie::selection()->find($request->id);

            if(! $movie){
                session()->flash('error','There is no item with this id');
                return redirect()->back();
            }

            $oldImage =  $movie->image != null ? $movie->image : '';
            $image_path = $this->uploadImage($request, 'image' , 'movies', $oldImage );

            $requestData = $request->all();
            $requestData['image'] = $image_path;

            $movie->update($requestData);

            session()->flash('Update','Updated successfully');
            return redirect()->route('movies');

        } catch (\Exception $ex) {
            session()->flash('error','Something went wrong, please try again');
            return redirect()->back()->withErrors(['error' => $ex->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {

            $movie = Movie::withTrashed()->find($request->id);

            if(! $movie){
                session()->flash('error','There is no item with this id');
                return redirect()->back();
            }

            if ($movie->image)
                $this->deleteImage($movie->image);

            $movie->forceDelete();

            session()->flash('Destroy','Deleted successfully');
            return redirect()->route('movies.trash');

        }catch (\Exception $ex) {
            session()->flash('error','Something went wrong, please try again');
            return redirect()->back()->withErrors(['error' => $ex->getMessage()]);
        }
    }

    public function softDelete($id)
    {
        try {

            $movie = Movie::selection()->find($id);

            if(! $movie){
                session()->flash('error','There is no item with this id');
                return redirect()->back();
            }

            $movie->delete();

            session()->flash('SoftDelete','Archive successfully');
            return redirect()->route('movies');

        }catch (\Exception $ex) {
            session()->flash('error','Something went wrong, please try again');
            return redirect()->back()->withErrors(['error' => $ex->getMessage()]);
        }
    }

    public function restore($id)
    {
        try {

            $movie = Movie::withTrashed()->find($id);

            if(! $movie){
                session()->flash('error','There is no item with this id');
                return redirect()->back();
            }

            $movie->restore();

            session()->flash('Restore','Recovery completed successfully');
            return redirect()->route('movies');

       }catch (\Exception $ex) {
            session()->flash('error','Something went wrong, please try again');
            return redirect()->back()->withErrors(['error' => $ex->getMessage()]);
       }

    }



}
