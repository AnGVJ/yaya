<?php

// app/Http/Controllers/ProyectoController.php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Imports\ProyectosImport;

class ProyectoController extends Controller
{
    public function index()
    {
        $proyectos = Proyecto::all();
        return view('proyectos.index', compact('proyectos'));
    }
    public function showProyectosEnDashboard()
    {
        // Obtener todos los proyectos de la base de datos
        $proyectos = Proyecto::all();

        // Retornar la vista 'dashboard' con los proyectos
        return view('dashboard', compact('proyectos'));
    }


    // Método para manejar la importación de proyectos
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        Excel::import(new ProyectosImport, $request->file('file'));

        return back()->with('success', 'Proyectos importados correctamente.');
    }


    public function create()
    {
        return view('proyectos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Codigo' => 'required|string|max:5',
            'Nombreproyecto' => 'required|string|max:200',
            'Fechainicio' => 'required|date',
            'Fechafinal' => 'required|date',
            'Avance' => 'required|integer',
            'Municipiodelaobra' => 'required|string|max:105',
            'Localidad' => 'required|string|max:500',
            'NoOficio' => 'required|string|max:45',
            'Montototal' => 'required|integer',
            'Abono' => 'required|integer',
            'Estado' => 'nullable|string|max:30', // Validación para el campo estado
        ]);

        Proyecto::create($validated);

        return redirect()->route('proyectos.index')->with('success', 'Proyecto creado con éxito');
    }

    public function edit($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        return view('proyectos.edit', compact('proyecto'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'Codigo' => 'required|string|max:5',
            'Nombreproyecto' => 'required|string|max:200',
            'Fechainicio' => 'required|date',
            'Fechafinal' => 'required|date',
            'Avance' => 'required|integer',
            'Municipiodelaobra' => 'required|string|max:105',
            'Localidad' => 'required|string|max:500',
            'NoOficio' => 'required|string|max:45',
            'Montototal' => 'required|integer',
            'Abono' => 'required|integer',
            'Estado' => 'nullable|string|max:30', // Validación para el campo estado
        ]);

        $proyecto = Proyecto::findOrFail($id);
        $proyecto->update($validated);

        return redirect()->route('proyectos.index')->with('success', 'Proyecto actualizado con éxito');
    }

    public function destroy($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $proyecto->delete();

        return redirect()->route('proyectos.index')->with('success', 'Proyecto eliminado con éxito');
    }
}
