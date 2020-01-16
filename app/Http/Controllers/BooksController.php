<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Author;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();
//        $authors = Author::select(DB::raw('concat(surname, " ", name) as full_name'), 'id')->get();
        return view('books', ['books' => $books, 'authors' => Author::all()]);
    }

   public function searchBook (Request $request){
       $search = $request->search;
       $books = DB::table('books')
           ->where('title','like',"$search%")
           ->get();

       return view('books',['books' => $books,'authors' => Author::all()]);
   }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = array(
            'title' => 'required',
            'publicated' => 'required',
        );

        $error = Validator::make($request->all(), $rules);

        if ($request->file('image') == null) {
            $storageLink = "";
        } else {
            $path = $request->file('image')->store('uploads', 'public');
            $storageLink = basename($path);
        }
        if ($error->fails()) {
            return response()->json(['errors' => $error->getMessageBag()->toArray()]);
        }

        $book = new Book;
        $book->title = $request->title;
        $book->description = $request->description;
        $book->publicated = $request->publicated;
        $book->image = $storageLink;
        $book->save();
        return response()->json($book);
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
        $book = Book::find($request->id);
        $book->title = $request->title;
        $book->description = $request->description;
        $book->publicated = $request->publicated;
        $book->save();
        return response()->json();
    }

    public function destroy(Request $request)
    {
        $book = Book::find ($request->id)->delete();
        return response()->json();
    }
}
