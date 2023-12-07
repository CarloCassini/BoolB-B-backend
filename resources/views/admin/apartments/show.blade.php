@extends('layouts.app')

@section('navigation-buttons')
    <div class="container">
        {{-- per tornare alla index --}}
        <div class=" my-3 d-flex">
            {{-- per tornare alla dashboard --}}
            <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i>
                Torna alla Dashboard
            </a>



            {{-- attivazione sponsor --}}

            <a href="{{ route('sponsorSelect', $apartment->id) }}"button class="btn btn-outline-primary ms-auto me-2 ">
                Sponsorizza
                </button>

                {{-- per modificare l'appartamento --}}
                <a href="{{ route('admin.apartments.edit', $apartment) }}" class="btn btn-outline-warning  me-2 ">
                    <i class="fa-solid fa-pencil "></i>
                    modifica appartamento
                </a>
                {{-- per cancellare l'appartamento --}}
                <a href="#"data-bs-toggle="modal" data-bs-target="#modal-{{ $apartment->id }}"
                    class="btn btn-outline-danger me-2">
                    <i class="fa-solid fa-trash text-danger"></i>
                    elimina appartamento
                </a>


                {{-- per visualizzare le statistiche dell'appartamento --}}
                <a href="{{ route('show.statistics', $apartment->id) }}" class="btn btn-outline-info">
                    <i class="fa-solid fa-chart-simple text-info"></i>
                    statistiche appartamento
                </a>
        </div>
    </div>
@endsection
@section('content')
    <div class="container mt-5">
        <div class="row g-3">
            <div class="col-12 col-lg-4">
                <img class="img-fluid" alt="cover" {{-- controllo sul src delle immagini (3 possibilità) --}}
                    src="@if (!$apartment->cover_image_path) https://via.placeholder.com/2000x1500.png/333333?text=Placeholder
                 @elseif(Str::startsWith($apartment->cover_image_path, ['http://', 'https://']))
                    {{ $apartment->cover_image_path }}
                 @else
                    {{ asset('/storage/' . $apartment->cover_image_path) }} @endif">
                <div class="sponsor mt-4">
                    @if ($sponsor)
                        <div class="card text-bg-primary mb-4" style="max-width: 12rem;">
                            <div class="card-header">Sponsorizzato</div>
                            <div class="card-body">
                                <p class="card-text"> inizio sponsor: {{ $sponsor->start_date }}</p>
                                <p class="card-text"> fine sponsor: {{ $sponsor->end_date }}</p>
                            </div>
                        </div>
                    @else
                        <div class="card text-bg-danger mb-4" style="max-width: 12rem;">
                            <div class="card-header">Non Sponsorizzato</div>
                            <div class="card-body">
                                <p class="card-text">Sponsorizzazione NON ATTIVA </p>
                            </div>
                            <a href="{{ route('sponsorSelect', $apartment->id) }}" class="mx-1">
                                <div class=" btn btn-success"> sponsorize
                                    <i class="fa-solid fa-money-check-dollar"></i>
                                </div>
                            </a>
                        </div>
                    @endif
                </div>
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
