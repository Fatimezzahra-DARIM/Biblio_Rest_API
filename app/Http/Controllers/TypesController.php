<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeRequest;
use App\Models\Type;
use Illuminate\Http\Request;
// use App\Http\Request\TypeRequest;
// use App\Http\Requests\TypeRequest as RequestsTypeRequest;

class TypesController extends Controller
{
    public function index()
    {
        $Type = Type::all();
        return response()->json(['response' => 'success', 'categories' => $Type]);
    }
    /* Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request = $request->validate([
            'name' => 'required',
        ]);
        // dd($request);
        $data = Type::create(['name'=> request('name')]);
        return response()->json(['created' => 'Type created successfuly', 'Type' => $data], 201);
    }

    /* Display the specified resource.
     */
    public function show($id)
    {
        if (!Type::find($id)) {
            return response()->json(['response' => 'not found'], 404);
        }
        // return response()->json(['response'=>'not found'],404);
        return Type::find($id);
    }
    /* Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $Type_update = Type::find($id);
        $Type_update->update($request->all());
        return response()->json(['Updated' => 'Type Updated successfuly', 'Type' => $Type_update], 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       Type::destroy($id);
        return response()->json(['deleted' => 'Type deleted successfuly'], 201);

        
    }

}
