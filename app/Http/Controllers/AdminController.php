<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function store(Request $request)
    {
       
            return response()->json(['created' => 'Not authorized as a admin to create', 'Book' ], 201);
       
    }
    public function update(Request $request,  $id){
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
