@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="debug">per la creazione</div>

        <form action="{{ route('admin.apartments.store') }}" method="POST">
            @csrf

            {{-- campo testuale --}}
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="name" name="name" />

            {{-- campo in select --}}
            <label for="type" class="form-label">Tipo</label>
            <select class="form-select" id="type" name="type">
                <option value="lunga">Lunga</option>
                <option value="corta">Corta</option>
                <option value="cortissima">Cortissima</option>
            </select>

            {{-- campo in numerico --}}
            <label for="cooking_time" class="form-label">Tempo di cottura</label>
            <input type="number" class="form-control" id="cooking_time" name="cooking_time" />


            <button type="submit" class="btn btn-primary">Salva</button>
        </form>
    </div>
@endsection
