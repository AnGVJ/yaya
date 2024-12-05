<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use App\Imports\MaterialesImport;
use Maatwebsite\Excel\Facades\Excel;

class MaterialController extends Controller
{

    public function import(Request $request)
    {
        // Validar que se haya subido un archivo
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        // Importar los datos
        Excel::import(new MaterialesImport, $request->file('file'));

        // Redirigir con un mensaje de éxito
        return redirect()->route('materiales.index')->with('success', 'Datos importados con éxito.');
    }





    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $materiales = Material::paginate(10);
        return view('materiales.index', compact('materiales'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('materiales.create');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required',
            'concepto' => 'required',
            'unidad' => 'required',
            'fecha' => 'required|date',
            'cantidad' => 'required|numeric',
            'obra' => 'required',
            'estado' => 'required|in:completo,incompleto,pendiente',
        ]);

        Material::create($request->all());
        return redirect()->route('materiales.index')->with('success', 'Material creado con éxito.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $material = Material::findOrFail($id); // Busca el material o lanza un error 404
        return view('materiales.edit', compact('material'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        $material->update($request->all()); // Actualiza los campos con los datos enviados
        return redirect()->route('materiales.index')->with('success', 'Material actualizado con éxito.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Buscar el material por su id
        $material = Material::find($id);

        if ($material) {
            // Eliminar el material
            $material->delete();

            // Redirigir con un mensaje de éxito
            return redirect()->route('materiales.index')->with('success', 'Material eliminado con éxito.');
        } else {
            // Si no se encuentra el material, redirigir con un mensaje de error
            return redirect()->route('materiales.index')->with('error', 'El material no se encontró.');
        }
    }


}
