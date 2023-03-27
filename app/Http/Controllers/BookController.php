<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Dflydev\DotAccessData\Data;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class BookController extends Controller
{
    public function index()
    {
        $book = Book::with(['collection', 'type'])->get();
        return response()->json([$book]);
    }
    /* Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = JWTAuth::user();
        $request = $request->validate([
            // 'name' => 'required',
            'title' => 'required',
            'author' => 'required',
            'isbn' => 'required',
            'content' => 'required',
            'publication_Date' => 'required',
            'number_of_pages' => 'required',
            'location' => 'required',
            'Status' => 'required',
            'type_id' => 'required',
            'collection_id' => 'required',
        ]);
        // dd($request);
        try{
            $data = Book::create([
            'title'=> request('title'),
            'author'=> request('author'),
            'isbn'=> request('isbn'),
            'content'=> request('content'),
            'publication_Date'=> request('publication_Date'),
            'number_of_pages'=> request('number_of_pages'),
            'location'=> request('location'),
            'Status'=> request('Status'),
            'type_id'=> request('type_id'),
            'collection_id'=> request('collection_id'),
            'user_id' => 1 ,    
        ]);
        
        return response()->json(['created' => 'Book created successfuly', 'Book' =>  $data], 201);
    }catch(Exception $e){
        return response()->json($e);
    }
    }

    /* Display the specified resource.
     */
    public function show($request)
    {
            $book = Book::with('collection', 'type')->whereHas('type', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request . '%');
            })->get();
            return response()->json([$book]);
    }
    /* Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $Book_update = Book::find($id);
        $Book_update->update($request->all());
        return response()->json(['Updated' => 'Book Updated successfuly', 'Book' => $Book_update], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Book::destroy($id);
        return response()->json(['deleted' => 'Book deleted successfuly'], 201);
    }
}
