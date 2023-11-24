@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- per tornare alla index --}}

        <h1 class="my-3 text-center">modifica apartment</h1>
        <div class="debug my-5 d-flex">
            <a href="{{ route('admin.apartments.index') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i>
                Torna alla lista
            </a>

            {{-- per cancellare l'appartamento --}}
            <a href="#"data-bs-toggle="modal" data-bs-target="#modal-{{ $apartment->id }}"
                class="btn btn-outline-danger ms-auto">
                <i class="fa-solid fa-trash text-danger"></i>
                elimina appartamento
            </a>
        </div>


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
        <form action="{{ route('admin.apartments.update', $apartment) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- title --}}
            <h6>i campi con l'* sono obbligatori</h6>
            <div>
                <label for="title" class="form-label">Title*</label>
                <input type="text" name="title" id="title"
                    class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title') ?? $apartment->title }}">
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
                    rows="5">{{ old('description') ?? $apartment->description }}</textarea>
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
                    class="form-control @error('rooms') is-invalid @enderror"
                    value="{{ old('rooms') ?? $apartment->rooms }}">
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
                    value="{{ old('beds') ?? $apartment->beds }}">
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
                    class="form-control @error('bathrooms') is-invalid @enderror"
                    value="{{ old('bathrooms') ?? $apartment->bathrooms }}">
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
                    value="{{ old('m2') ?? $apartment->m2 }}">
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
                    class="form-control @error('address') is-invalid @enderror"
                    value="{{ old('address') ?? $apartment->address }}">
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


            {{-- todo : gestione delle coordinate di latitudine e longitudine  --}}
            {{-- todo : gestione della cover image ::: è un campo nullable --}}
            {{-- todo : gestione della is_hidden ::: messo un default a 0 nel booleano --}}

            <button type="submit" class="btn btn-primary my-3">Salva</button>
        </form>
    </div>


    {{-- * modals --}}

    <div class="modal fade" tabindex="-1" id="modal-{{ $apartment->id }}">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header red-strip">
                    <h5 class="modal-title">DELETE FROM DATABASE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <strong class="text-danger text-align-center">W A R N I N G</strong> <br>
                    <hr>

                    <p> Are you shure you want to delete permanently:
                        <br>
                        <strong>
                            ' {{ $apartment->title }} '
                        </strong>
                        <br>
                        <strong>
                            ID :
                        </strong>
                        {{ $apartment->id }}
                        <br>
                        from the database?
                    </p>
                    <p class="text-danger">THIS ACTION IS IRREVERSIBLE</p>

                    <hr>

                    <form action="{{ route('admin.apartments.destroy', $apartment) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="send" class="btn btn-outline-danger"><strong>DELETE</strong></button>
                    </form>
                </div>
                <div class="modal-footer red-strip"">
                </div>
            </div>
        </div>
    </div>
@endsection
