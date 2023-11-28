@extends('layouts.app')

@section('navigation-buttons')
    <div class="container">
        <h1 class="my-3 text-center">dettaglio apartment</h1>
        {{-- per tornare alla index --}}
        <div class=" my-5 d-flex">
            <a href="{{ route('admin.apartments.index') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i>
                Torna alla lista
            </a>

            {{-- per modificare l'appartamento --}}
            <a href="{{ route('admin.apartments.edit', $apartment) }}" class="btn btn-outline-warning ms-auto me-2 ">
                <i class="fa-solid fa-pencil "></i>
                modifica appartamento
            </a>
            {{-- per cancellare l'appartamento --}}
            <a href="#"data-bs-toggle="modal" data-bs-target="#modal-{{ $apartment->id }}"
                class="btn btn-outline-danger ">
                <i class="fa-solid fa-trash text-danger"></i>
                elimina appartamento
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="container mt-5">

        <div class="row g-3">
            <div class="col-12 col-lg-4">
                <img src="@if ($apartment->cover_image_path) {{ asset('storage/' . $apartment->cover_image_path) }}@else{{ 'https://via.placeholder.com/2000x1500.png/333333?tex' }} @endif"
                    class="img-fluid" alt="cover">
            </div>
            <div class="col-12 col-lg-8 text-center text-lg-start d-flex flex-column justify-content-between">
                <h1>{{ $apartment->title }}</h1>
                <h5>{{ $apartment->id }}
                    {{ $apartment->user_id }}
                </h5>
                <p>
                    <strong>Camere : </strong>
                    @if ($apartment->rooms)
                        {{ $apartment->rooms }}
                    @else
                        -
                    @endif
                </p>
                <p>
                    <strong>Letti : </strong>

                    @if ($apartment->beds)
                        {{ $apartment->beds }}
                    @else
                        -
                    @endif
                </p>
                <p>
                    <strong>Bagni : </strong>

                    @if ($apartment->bathrooms)
                        {{ $apartment->bathrooms }}
                    @else
                        -
                    @endif
                </p>
                <p>
                    <strong>Posti letto : </strong>

                    @if ($apartment->beds)
                        {{ $apartment->beds }}
                    @else
                        -
                    @endif
                </p>
                <p>
                    <strong>Metri Quadrati : </strong>
                    @if ($apartment->m2)
                        {{ $apartment->m2 }}
                    @else
                        -
                    @endif
                </p>
                <p>
                    <strong>Indirizzo : </strong>
                    @if ($apartment->address)
                        {{ $apartment->address }}
                    @else
                        -
                    @endif
                </p>
                <p>
                    <strong>Descrizione : </strong>
                    @if ($apartment->description)
                        {{ $apartment->description }}
                    @else
                        -
                    @endif
                </p>
                <p>
                    <strong>Anteprima : </strong>
                    @if ($apartment->cover_img_path)
                        {{ $apartment->cover_img_path }}
                    @else
                        -
                    @endif
                </p>
                <p>
                    <strong>Posizione : </strong>
                    @if ($apartment->latitude_int)
                        {{ $apartment->latitude_int }}
                    @else
                        -
                    @endif
                    @if ($apartment->longitude_int)
                        {{ $apartment->longitude_int }}
                    @else
                        -
                    @endif
                </p>
                <p class="m-0">
                    <strong>Disponibile : </strong>
                    @if ($apartment->is_hidden)
                        {{ $apartment->is_hidden }}
                    @else
                        -
                    @endif
                </p>
            </div>
            {{-- <div class="col-12">
                <hr>
                <div class="row row-cols-1 row-cols-md-2">
                   
                    <div class="d-flex  flex-wrap">
                        @foreach ($services as $service)
                            <div class="col-4 mt-1">
    
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
                </div>
            </div>
        </div> --}}

            <div class="">
                <h4>Services</h4>
                <ul class="list-unstyled m-0 row row-cols-1 row-cols-md-2 g-3">
                    @foreach ($apartment->services as $service)
                        <li>
                            <i class="{{ $service->symbol }}"></i>
                            {{ $service->label }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endsection

    @section('modals')
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
