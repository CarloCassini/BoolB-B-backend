@extends('layouts.app')

@section('navigation-buttons')
    <div class="container">
        <h1 class="my-3 text-center">dettaglio apartment x guest generico</h1>
        {{-- per tornare alla index --}}
        <div class=" my-5 d-flex">
            <a href="{{ route('guest.home') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i>
                Back to homepage
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
            </div>
            <div class="col-12 col-lg-8 text-center text-lg-start d-flex flex-column justify-content-between">
                <h1>{{ $apartment->title }}</h1>
                <h5>{{ $apartment->id }}
                    {{ $apartment->user_id }}
                </h5>
                <p>
                    <strong>Rooms : </strong>
                    @if ($apartment->rooms)
                        {{ $apartment->rooms }}
                    @else
                        -
                    @endif
                </p>
                <p>
                    <strong>Beds : </strong>

                    @if ($apartment->beds)
                        {{ $apartment->beds }}
                    @else
                        -
                    @endif
                </p>
                <p>
                    <strong>Bathrooms: </strong>

                    @if ($apartment->bathrooms)
                        {{ $apartment->bathrooms }}
                    @else
                        -
                    @endif
                </p>
                <p>
                    <strong>Beds : </strong>

                    @if ($apartment->beds)
                        {{ $apartment->beds }}
                    @else
                        -
                    @endif
                </p>
                <p>
                    <strong>Surface : </strong>
                    @if ($apartment->m2)
                        {{ $apartment->m2 }}
                    @else
                        -
                    @endif
                </p>
                <p>
                    <strong>Address : </strong>
                    @if ($apartment->address)
                        {{ $apartment->address }}
                    @else
                        -
                    @endif
                </p>
                <p>
                    <strong>Description : </strong>
                    @if ($apartment->description)
                        {{ $apartment->description }}
                    @else
                        -
                    @endif
                </p>
                <p>
                    <strong>Preview : </strong>
                    @if ($apartment->cover_img_path)
                        {{ $apartment->cover_img_path }}
                    @else
                        -
                    @endif
                </p>
                <p>
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
                <p class="m-0">
                    <strong>Avable : </strong>
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
            <!--stampa in caso di successo dell'invio del messaggio-->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="col-12 border border-3 my-2">
                <h3 class="my-2">Send a message to the owner:</h3>
                <form action="{{ route('invia.messaggio') }}" method="POST">
                    @csrf
                    <div class="d-flex my-2">
                        <!--id appartamento associato-->
                        <input type="hidden" name="apartment_id" value="{{ $apartment->id }}">
                        <label for="sender_email">Email:</label>
                        @auth <!--verifica utente registrato ed eventuale autoinserimento email-->
                            <input type="email" name="sender_email" value="{{ auth()->user()->email }}" class="mx-2">
                        @else
                            <input type="email" id="sender_email" name="sender_email" value="{{ $user->email ?? '' }}"
                                placeholder="Inserisci la tua email" class="mx-2" required>
                        @endauth
                    </div>
                    <div class="d-flex my-2">
                        <label for="name">Name:</label>
                        @if (auth()->check())
                            <!--verifica utente registrato ed eventuale autoinserimento nome-->
                            <input type="text" name="name" value="{{ auth()->user()->name }}" class="mx-2">
                        @else
                            <input type="text" id="name" name="name" value="{{ $user->name ?? '' }}"
                                placeholder="Inserisci il tuo nome" class="mx-2">
                        @endif
                    </div>
                    <div>
                        <label for="surname">Surname:</label>
                        @if (auth()->check())
                            <!--verifica utente registrato ed eventuale autoinserimento cognome-->
                            <input type="text" name="surname" value="{{ auth()->user()->surname }}" class="mx-2">
                        @else
                            <input type="text" id="surname" name="surname" value="{{ $user->surname ?? '' }}"
                                placeholder="Inserisci il tuo cognome" class="mx-2">
                        @endif
                    </div>

                    <div class="d-flex flex-column justify-content-center my-3">
                        <label for="message">Message:</label>
                        <textarea id="message" name="message" rows="4" class="col-12 my-2" placeholder="Scrivi il tuo messaggio"
                            required></textarea>
                    </div>

                    <button type="submit" class="btn btn-secondary mb-2"><i class="fa-solid fa-paper-plane me-2"></i>Send message</button>
                </form>
            </div>
        </div>
    @endsection
