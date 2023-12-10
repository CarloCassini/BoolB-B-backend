@extends('layouts.app')

@section('navigation-buttons')
    
        {{-- per tornare alla index --}}
        <div class="d-flex flex-wrap">
            {{-- per tornare alla dashboard --}}
            <div class="me-5 my-2">
                <a href="{{ route('admin.home') }}" class="btn btn-style">
                    <i class="fa-solid fa-arrow-left me-1"></i>
                    Back to Dashboard
                </a>
            </div>
            {{-- attivazione sponsor --}}
            <div class="d-flex flex-wrap ms-auto my-2">
                <a href="{{ route('sponsorSelect', $apartment->id) }}"button class="btn btn-style me-3">
                Sponsor
                </button>
                {{-- per modificare l'appartamento --}}
    
                <a href="{{ route('admin.apartments.edit', $apartment) }}" class="btn btn-style me-3  ">
                    <i class="fa-solid fa-pencil "></i>
                    Edit
                </a>
                {{-- per cancellare l'appartamento --}}
    
                <a href="#"data-bs-toggle="modal" data-bs-target="#modal-{{ $apartment->id }}"
                    class="btn-style me-3 btn">
                    <i class="fa-solid fa-trash text-danger"></i>
                    Delete
                </a>
                {{-- per visualizzare le statistiche dell'appartamento --}}
    
                <a href="{{ route('show.statistics', $apartment->id) }}" class="btn btn-style me-3">
                    <i class="fa-solid fa-chart-simple text-info"></i>
                    Stats
                </a>
            </div>
        </div>

    </div>
@endsection
@section('content')
    <div class="container mt-3 ms-auto">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    {{-- *Apartment titlte --}}
                    <div class="card-header">
                        <h1>{{ $apartment->title }}</h1>
                    </div>
                    {{-- *Apartment-main --}}
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="row">
                                {{--* Apartment img/Sponsor --}}
                                <div class="col-lg-4">
                                    {{-- * IMG --}}
                                    <img class="img-fluid" alt="cover" {{--? controllo sul src delle immagini (3 possibilità) --}}
                                        src="@if (!$apartment->cover_image_path) https://via.placeholder.com/2000x1500.png/333333?text=Placeholder
                                            @elseif(Str::startsWith($apartment->cover_image_path, ['http://', 'https://']))
                                                {{ $apartment->cover_image_path }}
                                            @else
                                                {{ asset('/storage/' . $apartment->cover_image_path) }} @endif
                                    ">
                                    {{-- *SPONSOR --}}
                                    <div class="sponsor w-100 my-3">
                                        @if ($sponsor)
                                            <div class="card text-bg-primary p-2 mb-4" >
                                                <div class="card-header">Sponsored</div>
                                                <div class="card-body">
                                                    <p class="card-text"> start sponsor: {{ $sponsor->start_date }}</p>
                                                    <p class="card-text"> end sponsor: {{ $sponsor->end_date }}</p>
                                                </div>
                                            </div>
                                        @else
                                            <div class="card text-bg-danger p-2 mb-4">
                                                <div class="card-header">Not sponsored</div>
                                                <div class="card-body">
                                                    <p class="card-text">Sponsorship NOT ACTIVE </p>
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
                                {{--* Apartments Stats --}}
                                <div class="col-lg-4">
                                    <h4 class="subtitle">Apartment Info</h4>
                                    {{-- * Rooms --}}
                                    <p class="my-2">
                                        <strong>Rooms : </strong>
                                        @if ($apartment->rooms)
                                            {{ $apartment->rooms }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                    {{-- * Beds --}}
                                    <p class="my-2">
                                        <strong>Beds: </strong>
                    
                                        @if ($apartment->beds)
                                            {{ $apartment->beds }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                    {{-- * Bathrooms --}}
                                    <p class="my-2">
                                        <strong>Bathrooms:</strong>
                    
                                        @if ($apartment->bathrooms)
                                            {{ $apartment->bathrooms }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                    {{-- * Surface --}}
                                    <p class="my-2">
                                        <strong>Surface: </strong>
                                        @if ($apartment->m2)
                                            {{ $apartment->m2 }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                    {{-- * Address --}}
                                    <p class="my-2">
                                        <strong>Address : </strong>
                                        @if ($apartment->address)
                                            {{ $apartment->address }}
                                        @else
                                            -
                                        @endif
                                    </p>

                                    {{-- * Preview --}}
                                    <p class="my-2">
                                        <strong>Preview : </strong>
                                        @if ($apartment->cover_img_path)
                                            {{ $apartment->cover_img_path }}
                                        @else
                                            -
                                        @endif
                                    </p>

                                    {{-- * Position --}}
                                    <p  class="my-2">
                                        <strong>Position : </strong>
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
                                    {{-- * Avable --}}
                                    <p class="my-2">
                                        <strong>Avable : </strong>
                                        @if ($apartment->is_hidden)
                                            {{ $apartment->is_hidden }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                    {{-- * Description --}}
                                    <strong>Description : </strong>
                                    <p class="my-2">
                                        @if ($apartment->description)
                                            {{ $apartment->description }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                                {{-- * Apartment Services --}}
                                <div class="col-lg-4">
                                    <h4 class="subtitle">Services</h4>
                                    <ul class="list-unstyled">
                                        @foreach ($apartment->services as $service)
                                            <li class="my-2">
                                                <i class="{{ $service->symbol }} fs-4 me-3"></i>
                                                {{ $service->label }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                    
                </div>
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
