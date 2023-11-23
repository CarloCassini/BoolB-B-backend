@extends('layouts.app')

@section('content')
    <section class="container mt-5">
        <h1>{{ $title }}</h1>
        <div class="row row-cols-2 g-4">
            {{-- @foreach ($apartments as $apartment) --}}
            <div class="col">
                <div class="card">
                    <div class="card-header text-center">
                        {{ $apartment->title }}
                    </div>
                    <div class="card-header text-center">
                        {{ $apartment->title }}
                    </div>
                    <div class="d-flex">
                        <div class="card-body" style="max-width: 60%">
                            <ul class="list-unstyled">
                                <li>
                                    <strong>
                                        Id :
                                    </strong>
                                    <span>
                                        {{ $apartment->id }}
                                    </span>
                                </li>
                                <li>
                                    <strong>
                                        User :
                                    </strong>
                                    <span>
                                        {{ $apartment->user_id }}
                                    </span>
                                </li>
                                <li>
                                    <strong>
                                        Title :
                                    </strong>
                                    <span>
                                        {{ $apartment->title }}
                                    </span>
                                </li>
                                <li>
                                    <strong>
                                        Rooms :
                                    </strong>
                                    <span>
                                        {{ $apartment->rooms }}
                                    </span>
                                </li>
                                <li>
                                    <strong>
                                        Beds :
                                    </strong>
                                    <span>
                                        {{ $apartment->beds }}
                                    </span>
                                </li>
                                <li>
                                    <strong>
                                        Bathrooms :
                                    </strong>
                                    <span>
                                        {{ $apartment->bathrooms }}
                                    </span>
                                </li>
                                <li>
                                    <strong>
                                        M2 :
                                    </strong>
                                    <span>
                                        {{ $apartment->m2 }}
                                    </span>
                                </li>
                                <li>
                                    <strong>
                                        Adress :
                                    </strong>
                                    <span>
                                        {{ $apartment->address }}
                                    </span>
                                </li>
                                <li>
                                    <strong>
                                        Description :
                                    </strong>
                                    <span>
                                        {{ $apartment->description }}
                                    </span>
                                </li>
                                <li>
                                    <strong>
                                        Cover image :
                                    </strong>
                                    <span>
                                        {{ $apartment->cover_img_path }}
                                    </span>
                                </li>
                                <li>
                                    <strong>
                                        Latitude :
                                    </strong>
                                    <span>
                                        {{ $apartment->latitude_int }}
                                    </span>
                                </li>
                                <li>
                                    <strong>
                                        Longitude :
                                    </strong>
                                    <span>
                                        {{ $apartment->longitude_int }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <div class="m-auto">
                            <a href="#" class="btn btn-primary">APARTMENTS DETAIL</a>
                        </div>
                    </div>
                </div>
            </div>
            {{-- @endforeach --}}
        </div>
    </section>
@endsection
        
 
