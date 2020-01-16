<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AuthorsController extends Controller
{
    /**
     * Display a listing of the resource.
        *
        * @return \Illuminate\Http\Response
        */
    public function index()
    {
        $authors = DB::table('authors')->orderBy('id')->paginate(15);
        return view('authors',compact('authors'));
    }

    public function searchAuthor(Request $request){
        $search = $request->search;
        $authors = DB::table('authors')
            ->where('surname','like',"$search%")
            ->orWhere('name','like',"$search%")
            ->orWhere('patronymic','like', "$search%")
            ->paginate(15);
        return view('authors',compact('authors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = array(
            'surname' => 'required|min:3',
            'name' => 'required',
        );

        $error = Validator::make($request->all(), $rules);

        if ($error->fails())
        {
            return response()->json(['errors' => $error->getMessageBag()->toArray()]);
        }
        else {
            $author = new Author;
            $author->surname = $request->surname;
            $author->name = $request->name;
            $author->patronymic = $request->patronymic;
            $author->save();
            return response()->json($author);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $author = Author::find ($request->id);
        $author->surname = $request->surname;
        $author->name = $request->name;
        $author->patronymic = $request->patronymic;
        $author->save();
        return response()->json($author);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $author = Author::find ($request->id)->delete();
        return response()->json();
    }
}
