@extends('layouts.app')

@section('content')
    {{-- {{$sponsors}}
   <br>
   {{$apartment_id}} --}}

    <div class="card mt-0 box-shadow">
        <div class="card-body d-flex flex-column gap-3 py-3">

            {{-- Header --}}
            <div class="container">
                <div class="d-inline-block text-gradient">
                    <h1>Sponsorizza Appartamenti</h1>
                </div>

                <div class="container mt-2">
                    <p> CICCIO SPONSORIZZA
                    </p>
                </div>
                <div class="container">
                    <form action="{{ route('sponsorship') }}" method="POST" class="col-12 col-lg-6 mx-auto">
                        @csrf
                        <div class="card mb-3" style="box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);">
                            <div class="card-body">
                                <h2 class="card-title">Aquista una sponsorizzazione</h2>
                                <div class="form-group">
                                    <label for="sponsor_id">Scegli un pacchetto:</label><br>
                                    @foreach ($sponsors as $sponsor)
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="radio" name="sponsor_id"
                                                id="sponsor_{{ $sponsor->id }}" value="{{ $sponsor->id }}" required>
                                            <label class="form-check-label" for="sponsor_{{ $sponsor->id }}">
                                                {{ $sponsor->name }} (Prezzo: {{ $sponsor->price }}€, Durata:
                                                {{ $sponsor->time }}
                                                ore)
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <input type="text" name="apartment_id" value="{{ $apartment_id }}" class="d-none">
                                <div id="dropin-wrapper" class="mt-3">
                                    <div id="checkout-message"></div>
                                    <div id="dropin-container"></div>
                                    <button id="submit-button" class="btn btn-primary btn-block">Paga</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="debug container">

        <div class="debug">https://www.youtube.com/watch?v=kJ4X4Y1IWzA</div>
        <div class="debug">https://www.youtube.com/watch?v=1-Ge9IqbwNY</div>
    </div>
@endsection
