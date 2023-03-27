<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //
    public function role(Request $request, $id)
    {
        $user = User::find($id);
        $request->validate([
            'role_id' => 'required|string',
        ]);


        try {
            $user->role_id = $request->role_id;
            $user->update();
            return response()->json(['data' => $request->role_id]);
        } catch (Exception $e) {
            return response()->json(['error' => $e]);
        }
    }
}
