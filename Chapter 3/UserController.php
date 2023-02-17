<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Events\UserUpdate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userData = User::all();

        return response()->json($userData,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newData = $request->all();

        $newUser = User::create($newData);

        if ($newUser->id != '') {
            broadcast(new UserUpdate($newUser->name." telah berhasil ditambahkan"));

            return response()->json([
                'msg' => 'Simpan data user berhasil'
            ],200);
        }

        return response()->json([
            'msg' => 'Simpan data user gagal'
        ],500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userData = User::findOrFail($id);

        return response()->json($userData,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $userData = User::findOrFail($id);

        $newData = $request->all();

        if ($userData->update($newData)) {
            broadcast(new UserUpdate($userData->name." telah berhasil diperbarui"));

            return response()->json([
                'msg' => 'Data berhasil diperbarui'
            ],200);
        }
        return response()->json([
            'msg' => 'Data gagal diperbarui'
        ],500);    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userData = User::findOrFail($id);

        if ($userData->delete()) {
            broadcast(new UserUpdate($userData->name." telah berhasil dihapus"));

            return response()->json([
                'msg' => 'Data berhasil dihapus'
            ],200);
        }
        return response()->json([
            'msg' => 'Data gagal dihapus'
        ],500);
    }
}
