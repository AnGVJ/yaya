@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('materiales.create') }}" class="btn btn-primary mb-3">Agregar Material</a>
    <form action="{{ route('materiales.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="file">Subir archivo Excel</label>
            <input type="file" name="file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Importar</button>
    </form>


    <table class="table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Concepto</th>
                <th>Unidad</th>
                <th>Fecha</th>
                <th>Cantidad</th>

                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materiales as $material)
                    <tr>
                        <td>{{ $material->codigo }}</td>
                        <td>{{ $material->concepto }}</td>
                        <td>{{ $material->unidad }}</td>
                        <td>{{ $material->fecha }}</td>
                        <td>{{ $material->cantidad }}</td>

                        <td>
                            <span class="badge" style="background-color: 
                                {{ $material->estado === 'completo' ? 'green' :
                ($material->estado === 'incompleto' ? 'red' :
                    'yellow') }}">
                                {{ ucfirst($material->estado) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('materiales.edit', $material->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('materiales.destroy', $material->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {{ $materiales->links() }}
    </div>
</div>
@endsection