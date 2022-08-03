<?php

namespace App\Http\Controllers;

use App\Models\PlantillaDataDemo;
use Illuminate\Http\Request;
use App\MetaFritterVerso\TablaFront;
use App\MetaFritterVerso\ColumnasFront;
use Symfony\Component\Console\Helper\Table;

class PlantillaDataDemoController extends Controller
{

    public function showAll()
    {
        $data = PlantillaDataDemo::all();
        
        $columnas = ColumnasFront::columnasTablaDemo();
        $columns = TablaFront::getColumns($columnas);

        $response = [
            "status" => 200,
            "data" => $data,
            "columns" => $columns,
            "message" => "Info Actualizada",
            "props_table" => TablaFront::getPropsTable(),
            "type" => "success"
        ];
        return response()->json($response);
    }

    public function showOne($id)
    {
        return response()->json(PlantillaDataDemo::find($id));
    }

    public function create(Request $request)
    {
        $arr = $request->all();
        foreach ($arr as $value) {
            PlantillaDataDemo::create($value);
        }

        return response()->json($this->showAll(), 201);
    }

    public function update($id, Request $request)
    {
        $data = PlantillaDataDemo::findOrFail($id);
        $data->update($request->all());

        return response()->json($data, 200);
    }

    public function delete($id)
    {
        PlantillaDataDemo::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
    
    
    
    
}
