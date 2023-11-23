@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="debug">per la creazione</div>

        <form action="{{ route('admin.apartments.store') }}" method="POST">
            @csrf

            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="name" name="name" />

            <label for="number" class="form-label">N°</label>
            <input type="text" class="form-control" id="number" name="number" />

            <label for="type" class="form-label">Tipo</label>
            <select class="form-select" id="type" name="type">
                <option value="lunga">Lunga</option>
                <option value="corta">Corta</option>
                <option value="cortissima">Cortissima</option>
            </select>

            <label for="cooking_time" class="form-label">Tempo di cottura</label>
            <input type="number" class="form-control" id="cooking_time" name="cooking_time" />

            <label for="weight" class="form-label">Peso (g)</label>
            <input type="text" class="form-control" id="weight" name="weight" />

            <label for="img" class="form-label">img</label>
            <input type="text" class="form-control" id="img" name="img" />

            <label for="description" class="form-label">Descrizione</label>
            <textarea class="form-control" id="description" name="description" rows="4"></textarea>

            <button type="submit" class="btn btn-primary">Salva</button>
        </form>
    </div>
@endsection
