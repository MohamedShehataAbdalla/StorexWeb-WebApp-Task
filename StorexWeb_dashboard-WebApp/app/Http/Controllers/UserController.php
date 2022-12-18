<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Arr;
use DB;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::Selection()->latest()->paginate(12);
        return view('pages.users.index',compact('users'));
    }

    public function trash()
    {
        $users = User::onlyTrashed()->latest()->paginate(5);
        return view('pages.users.trash', compact('users'));
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
    public function store(AddUserRequest $request)
    {
        try {


            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $input['created_by'] = (Auth::user()->id);

            // return $request;

            $user = User::create($input);

            session()->flash('Store','Added successfully');
            return redirect()->route('users');

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
        $user = User::selection()->find($id);

        if(! $user){
            session()->flash('error','There is no item with this id');
            return redirect()->back();
        }

        return view('pages.users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
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
    public function update(UpdateUserRequest $request)
    {
        try {
            $user = User::selection()->find($request->id);

            if(! $user){
                session()->flash('error','There is no item with this id');
                return redirect()->back();
            }

            $input = $request->all();

            if(!empty($input['password'])){
                $input['password'] = Hash::make($input['password']);
            }else{
                $input = Arr::except($input,array('password'));
            }

            $user->update($input);

            session()->flash('Update','Updated successfully');
            return redirect()->route('users');

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

            $user = User::withTrashed()->find($request->id);

            if(! $user){
                session()->flash('error','There is no item with this id');
                return redirect()->back();
            }

            $user->forceDelete();

            session()->flash('Destroy','Deleted successfully');
            return redirect()->route('users.trash');

        }catch (\Exception $ex) {
            session()->flash('error','Something went wrong, please try again');
            return redirect()->back()->withErrors(['error' => $ex->getMessage()]);
        }
    }

    public function softDelete($id)
    {
        try {

            $user = User::selection()->find($id);

            if(! $user){
                session()->flash('error','There is no item with this id');
                return redirect()->back();
            }

            $user->delete();

            session()->flash('SoftDelete','Archive successfully');
            return redirect()->route('users');

        }catch (\Exception $ex) {
            session()->flash('error','Something went wrong, please try again');
            return redirect()->back()->withErrors(['error' => $ex->getMessage()]);
        }
    }

    public function restore($id)
    {
        try {

            $user = User::withTrashed()->find($id);

            if(! $user){
                session()->flash('error','There is no item with this id');
                return redirect()->back();
            }

            $user->restore();

            session()->flash('Restore','Recovery completed successfully');
            return redirect()->route('users');

       }catch (\Exception $ex) {
            session()->flash('error','Something went wrong, please try again');
            return redirect()->back()->withErrors(['error' => $ex->getMessage()]);
       }

    }
}
