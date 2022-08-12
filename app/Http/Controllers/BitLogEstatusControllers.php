<?php

namespace App\Http\Controllers;

use App\Models\BitLogEstatus;
use Illuminate\Http\Request;
use App\MetaFritterVerso\TablaFront;
use App\MetaFritterVerso\ColumnasFront;
use Symfony\Component\Console\Helper\Table;

class BitLogEstatusControllers extends Controller
{

    public function showAll()
    {
        $data = BitLogEstatus::all();
        
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
    
    public function showInspecciones($id)
    {
        //$data = BitLogEstatus::all();
        
        $data = BitLogEstatus::select(
                        BitLogEstatus::raw(" bit_log_estatus.fec_estatus AS fec_estatus"), 
                        BitLogEstatus::raw(" if(bit_log_estatus.result_inspeccion = 'aprobado', 'Aprobado', 'No aprobado') as result_inspeccion "), 
                       )->where("estatus", 'inspeccionado')->where("id_reg_veh",$id )->get();
        
        $columnas = ColumnasFront::columnasTablaInspecciones();
        $columns = TablaFront::getColumns($columnas);

        $response = [
            "status" => 200,
            "data" => $data,
            "columns" => $columns,
            "message" => "Info Actualizada",
            "props_table" => TablaFront::getPropsTable("Bitácora de inspecciones"),
            "type" => "success"
        ];
        return response()->json($response);
    }
    

    public function showOne($id)
    {
        return response()->json(BitLogEstatus::find($id));
    }

    public function create(Request $request)
    {
        $arr = $request->all();
        foreach ($arr as $value) {
            BitLogEstatus::create($value);
        }

        return response()->json($this->showAll(), 201);
    }

    public function update($id, Request $request)
    {
        $data = BitLogEstatus::findOrFail($id);
        $data->update($request->all());

        return response()->json($data, 200);
    }

    public function delete($id)
    {
        BitLogEstatus::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
