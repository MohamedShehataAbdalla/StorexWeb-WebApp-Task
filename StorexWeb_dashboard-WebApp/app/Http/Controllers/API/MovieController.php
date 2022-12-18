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
        return Movie::Selection()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddMovieRequest $request)
    {
        $image_path = $this->uploadImage($request, 'image' ,'movies');

        Movie::create([
            'title' => $request->title,
            'description' => $request->description,
            // 'rate' => $request->rate,
            'image' => $image_path,
            'category_id' => $request->category_id,
            'created_by' => (Auth::user()->id),
        ]);

        return response()->json([
            'message' => 'Movie Added successfully',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        return response()->json([
            'movie' => $movie,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        // $movie = Movie::selection()->find($request->id);

        // if(! $movie){
        //     session()->flash('error','There is no item with this id');
        //     return redirect()->back();
        // }

        $oldImage =  $movie->image != null ? $movie->image : '';
        $image_path = $this->uploadImage($request, 'image' , 'movies', $oldImage );

        $requestData = $request->all();
        $requestData['image'] = $image_path;

        $movie->fill($requestData)->update();

        return response()->json([
            'message' => 'Movie Updated successfully',
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {

        // $movie = Movie::withTrashed()->find($request->id);

        // if(! $movie){
        //     session()->flash('error','There is no item with this id');
        //     return redirect()->back();
        // }

        $movie->delete();

        return response()->json([
            'message' => 'Movie Deleted successfully',
        ]);

        
    }

}
