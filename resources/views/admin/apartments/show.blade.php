@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        {{-- per tornare alla index --}}

        <h1 class="my-3 text-center">modifica apartment</h1>
        <div class=" my-5 d-flex">
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

        <div class="row g-3">
            <div class="col-12 col-lg-4">
                <img src="@if ($apartment->cover_image_path) {{ $apartment->cover_image_path }}@else{{ 'https://via.placeholder.com/2000x1500.png/333333?tex' }} @endif"
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
            <div class="col-12 border border-3">
                <h3 class="my-4">Invia un messaggio al proprietario:</h3>
                <form action="" method="post">
                    @csrf
                    <div class="d-flex my-2">
                        <label for="sender_email">Email:</label>
                        <input type="email" id="sender_email" name="sender_email" placeholder="Inserisci la tua email"
                            class="mx-2" required>
                    </div>

                    <div class="d-flex flex-column justify-content-center my-3">
                        <label for="messages">Messaggio:</label>
                        <textarea id="messages_id" name="messages" rows="4" class="col-12 my-2" placeholder="Scrivi il tuo messaggio"
                            required></textarea>
                    </div>

                    <button type="submit" class="btn btn-secondary mb-2">Invia messaggio</button>
                </form>
            </div>
            <div class="col-12">
                <hr>
                <div class="row row-cols-1 row-cols-md-2">
                    <p>ciccio</p>
                    <p>ciccio</p>
                    <p>ciccio</p>
                    <p>ciccio</p>
                    <p>ciccio</p>
                    <p>ciccio</p>
                </div>
            </div>
        </div>

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
