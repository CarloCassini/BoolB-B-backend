@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fs-4 text-secondary my-4">
            {{ __('Dashboard') }}
        </h2>
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">{{ __('User Dashboard') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                        <div class="my-3">
                            <a class="btn btn-primary" href="{{ route('admin.apartments.index') }}">My Apartments</a>
                            {{-- <a class=" btn btn-success mx-3"
                        href="{{route('admin.messages')}}">My Messages</a> --}}

                            <div class="border my-1">
                                <a class="my-2 btn btn-warning" href="#">view apartment</a>
                                <div>
                                    cliccando un appartamento dalla lista appartamenti deve rendere la vista dello stesso
                                </div>
                            </div>
                            <div class="border my-1">
                                <a class="my-2 btn btn-warning" href="#">sponsor an apartment(generico)</a>
                                <div>
                                    rende la possibilità di collegare una sponsorizzazione legandola a una lista di
                                    appartamenti specifici
                                </div>
                            </div>
                            <div class="border my-1">
                                <a class="my-2 btn btn-warning" href="#">apartment statistics(dedicato a un
                                    apaartamento
                                    specifico)</a>
                                <div>
                                    apre le statistiche dell'appartamento, deve essere legato a una selezione precisa
                                    dell'appartamento di riferimento
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
