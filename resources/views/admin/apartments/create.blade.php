@extends('layouts.app')

@section('navigation-buttons')
    <div class="container">
        <h1 class="my-3 text-center">crea apartment</h1>
        {{-- per tornare alla index --}}
        <h1 class="my-3 text-center">Crea apartment</h1>
        <div class=" my-5">
            <a href="{{ route('admin.apartments.index') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i>
                Torna alla lista
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">

        {{-- gestione degli errori --}}
        @if ($errors->any())
            <div class="alert alert-warning">
                <h5>correggi i seguenti errori</h5>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- corpo --}}
        <form action="{{ route('admin.apartments.store') }}" method="POST">
            @csrf

            <h6>i campi con l'* sono obbligatori</h6>

            {{-- title --}}
            <div>
                <label for="title" class="form-label">title</label>
                <input type="text" name="title" id="title"
                    class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- description --}}
            <div class="col-12 mb-4">
                <label for="description" class="form-label">description</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                    rows="5">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- rooms --}}
            <div>
                <label for="rooms" class="form-label">rooms*</label>
                <input type="number" name="rooms" id="rooms"
                    class="form-control @error('rooms') is-invalid @enderror" value="{{ old('rooms') }}">
                @error('rooms')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- beds --}}
            <div>
                <label for="beds" class="form-label">beds*</label>
                <input type="number" name="beds" id="beds" class="form-control @error('beds') is-invalid @enderror"
                    value="{{ old('beds') }}">
                @error('beds')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- bathrooms --}}
            <div>
                <label for="bathrooms" class="form-label">bathrooms*</label>
                <input type="number" name="bathrooms" id="bathrooms"
                    class="form-control @error('bathrooms') is-invalid @enderror" value="{{ old('bathrooms') }}">
                @error('bathrooms')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- m2 --}}
            <div>
                <label for="m2" class="form-label">m2*</label>
                <input type="number" name="m2" id="m2" class="form-control @error('m2') is-invalid @enderror"
                    value="{{ old('m2') }}">
                @error('m2')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- address --}}
            <div>
                <label for="address" class="form-label">address*</label>
                <input type="text" name="address" id="address"
                    class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}">
                @error('address')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Services  --}}
            <label class="form-label my-3">services</label>

            <div class="form-check @error('tags') is-invalid @enderror p-0">
                <div class="d-flex  flex-wrap">
                    @foreach ($services as $service)
                        <div class="col-3 mt-1">

                            <input type="checkbox" id="service-{{ $service->id }}" value="{{ $service->id }}"
                                name="services[]" class="form-check-control me-2"
                                @if (in_array($service->id, old('services', $apartment_service ?? []))) checked @endif>
                            <label for="service-{{ $service->id }}">
                                <i class="{{ $service->symbol }}"></i> - {{ $service->label }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            @error('services')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            {{-- todo : inserimento dello user della sessione --}}
            {{-- todo : gestione delle coordinate di latitudine e longitudine  --}}
            {{-- todo : gestione della cover image ::: è un campo nullable --}}
            {{-- todo : gestione della is_hidden ::: messo un default a 0 nel booleano --}}

            <button type="submit" class="btn btn-primary my-3">Salva</button>
        </form>
    </div>
@endsection
