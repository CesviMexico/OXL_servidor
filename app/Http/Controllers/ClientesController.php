<?php

namespace App\Http\Controllers;

use App\Models\BitClientes;
use Illuminate\Http\Request;

class ClientesController extends Controller
{

    public function showAll()
    {
        return response()->json(BitClientes::all());
    }

    public function showOne($id)
    {
        return response()->json(BitClientes::find($id));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required'
        ]);

        $data = BitClientes::create($request->all());

        return response()->json($data, 201);
    }

    public function update($id, Request $request)
    {
        $data = BitClientes::findOrFail($id);
        $data->update($request->all());

        return response()->json($data, 200);
    }

    public function delete($id)
    {
        BitClientes::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}

