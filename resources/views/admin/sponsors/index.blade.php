@extends('layouts.base')

@section('contents')
    <div class="card mt-0 box-shadow">
        <div class="card-body d-flex flex-column gap-3 py-3">

            {{-- Header --}}
            <div class="container">
                <div class="d-inline-block text-gradient">
                    <h1>Sponsorizza Appartamenti</h1>
                </div>
                <hr class="m-0">
            </div>

            @if (count($apartments))
                <div class="container">
                    <p>ciccio
                    </p>
                </div>

                <div class="container">
                    <form id="payment-form" method="post"
                        class="col-12 col-lg-6 mx-auto">
                        @csrf
                        <div class="card mb-3" style="box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);">
                            <div class="card-body">
                                <h2 class="card-title">Aquista una sponsorizzazione</h2>
                                <div class="form-group">
                                    <label for="sponsor_id">Scegli un pacchetto:</label><br>
                                    @foreach ($sponsors as $sponsor)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="sponsor_id"
                                                id="sponsor_{{ $sponsor->id }}" value="{{ $sponsor->id }}" required>
                                            <label class="form-check-label" for="sponsor_{{ $sponsor->id }}">
                                                {{ $sponsor->name }} (Prezzo: {{ $sponsor->price }}€, Durata:
                                                {{ $sponsor->time }}
                                                ore)
                                            </label>
                                        </div>
                                    @endforeach

                                    {{-- Errore --}}
                                    @error('sponsor_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <label for="apartment_id">Scegli un appartamento:</label>
                                    <select name="apartment_id" id="apartment_id" class="form-control" required>
                                        <option value="">Scegli un appartamento</option>
                                        @foreach ($apartments as $apartment)
                                            <option value="{{ $apartment->id }}">
                                                {{ $apartment->title }}
                                            </option>
                                        @endforeach
                                    </select>

                                    {{-- Errore --}}
                                    @error('apartment_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div id="dropin-wrapper" class="mt-3">
                                    <button id="submit-button" class="btn btn-primary btn-block">Paga</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <div class="container">
                    <h2>Non disponi di alcun appartamento</h2>
                    <button class="style-btn">Aggiungi</button>
                </div>
            @endif
        </div>
    </div>
@endsection

<style>
    .button {
        cursor: pointer;
        font-weight: 500;
        left: 3px;
        line-height: inherit;
        position: relative;
        text-decoration: none;
        text-align: center;
        border-style: solid;
        border-width: 1px;
        border-radius: 3px;
        -webkit-appearance: none;
        -moz-appearance: none;
        display: inline-block;
    }

    .button--small {
        padding: 10px 20px;
        font-size: 0.875rem;
    }

    .button--green {
        outline: none;
        background-color: #64d18a;
        border-color: #64d18a;
        color: white;
        transition: all 200ms ease;
    }

    .button--green:hover {
        background-color: #8bdda8;
        color: white;
    }
</style>