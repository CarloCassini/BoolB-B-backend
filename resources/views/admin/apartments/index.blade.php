@extends('layouts.app')

@section('main-content')
    <section class="container mt-5">
        <div class="row">
            <h1 class="mb-3">Detail section</h1>
            <div>
                <a href="{{ route('apartment.index') }}" class="btn btn-primary mb-3">GO BACK</a>
            </div>
            <div class="col-6 mx-auto">
                <div class="card">
                    <div class="card-header text-center">
                        {{ $apartment->title }}
                    </div>
                    <div class="d-flex">
                        <div class="card-body" style="max-width: 60%">
                            <ul class="list-unstyled">
                                <li>
                                    <strong>
                                        ID :
                                    </strong>
                                    <span>
                                        {{ $apartment->id }}
                                    </span>
                                </li>
                                <li>
                                    <strong>
                                        USER :
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
                                        ROOMS :
                                    </strong>
                                    <span>
                                        {{ $apartment->rooms }}
                                    </span>
                                </li>
                                <li>
                                    <strong>
                                        BEDS :
                                    </strong>
                                    <span>
                                        {{ $apartment->beds }}
                                    </span>
                                </li>
                                <li>
                                    <strong>
                                        BATHROOMS :
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
                                        AVABLE :
                                    </strong>
                                    <span>
                                        {{ $apartment->is_hidden }}
                                    </span>
                                </li>
                                <li>
                                    <strong>
                                        ADDRESS :
                                    </strong>
                                    <span>
                                        {{ $apartment->address }}
                                    </span>
                                </li>
                                <li>
                                    <strong>
                                        DESCRIPTION :
                                    </strong>
                                    <span>
                                        {{ $apartment->description }}
                                    </span>
                                </li>
                                <li>
                                    <strong>
                                        COVER IMAGE :
                                    </strong>
                                    <span>
                                        {{ $apartment->cover_img_path }}
                                    </span>
                                </li>
                                <li>
                                    <strong>
                                        LATITUDE :
                                    </strong>
                                    <span>
                                        {{ $apartment->latitude_int }}
                                    </span>
                                </li>
                                <li>
                                    <strong>
                                        LONGITUDE :
                                    </strong>
                                    <span>
                                        {{ $apartment->longitude_int }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- @endforeach --}}
        </div>
    </section>
@endsection
