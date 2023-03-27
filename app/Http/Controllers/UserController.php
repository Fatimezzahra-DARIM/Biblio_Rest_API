<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Validators\Validator;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json(['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        try {
            request()->validate([
                'name' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required|confirmed|min:6'
            ]);

            // $user = new User;
            // $user->name = request('name');
            // $user->email = request('email');
            // $user->password = Hash::make(request('password'));
            // $user->save();

            User::create([
                'name' => request('name'),
                'email' => request('email'),
                'password' => Hash::make(request('password'))
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

        return response()->json(['success' => 'account has been created successfully']);
    }

    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }


        
        

        // $validator = Validator::make($updatedData, [
        //     'name' => 'nullable|string|min:3|max:255',
        //     'email' => 'nullable|email|max:255|unique:users,email,' . $id
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => $validator->errors()
        //     ], 422);
        // }

        // $user->fill($request->only(['name', 'email']));
        $user->name = $request->name;
        $user->email = $request->email;
        //dd($user->name, $user->email);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'data' => $user
        ]);
        // echo 'hyyy';
        // die($request);
        //
        // $user = User::find($id);
        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->save();
        // $user->update();

        // $profil = User::find($id);
        // $profil->fill($request->all());
        // $profil->update();

        // return response()->json($user, 200);

    }
    public function updatePassword(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $validated = $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required',
            'confirmPassword' => 'required|same:newPassword',
        ]);
        // dd($request);
        //    echo  Hash::make($validated['oldPassword']);
        //    echo '<hr>'. Auth::user()->password;
        if (Hash::check($validated['oldPassword'], Auth::user()->password)) {
            $user->password = Hash::make($validated['newPassword']);
            $user->update();
            return response()->json($user, 200);

        }

        return response()->json($user, 400);
        // return response()->json(['hi'=>'hi']);
    }

 

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
