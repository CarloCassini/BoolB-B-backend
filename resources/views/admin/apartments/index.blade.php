@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Apartments - {{ $user->first_name }}</h1>
        <h6 class="text-secondary">Clicca sulle card per maggiori informazioni</h6>
        <div class="row row-cols-lg-4 row-cols-1 g-4 ">

            @foreach ($apartments as $apartment)
                <div class="col">
                    <a href="{{ route('admin.apartments.show', $apartment) }}" class=" text-decoration-none text-dark">
                        <div class="card h-100 text-center">
                            <div class="card-image">
                                @if ($apartment->cover_img)
                                    <img src="{{ asset('/storage/' . $apartment->cover_img) }}" alt=""
                                        class="image-fluid w-100">
                                @else
                                <img src="https://placehold.co/400" alt="" class="image-fluid w-100">
                                @endif
                            </div>
                            <div class="card-header">
                                <h5 class="card-title">
                                    {{ $apartment->id }}
                                    {{ $apartment->user_id }}
                                    {{ $apartment->title }}
                                </h5>
                            </div>
                            <div class="card-body pb-0 text-start">
                                <p>
                                    @if ($apartment->rooms)
                                        {{ $apartment->rooms }}
                                    @else
                                        -
                                    @endif
                                </p>
                                <p>
                                    @if ($apartment->beds)
                                        {{ $apartment->beds }}
                                    @else
                                        -
                                    @endif
                                </p>
                                <p>
                                    @if ($apartment->bathrooms)
                                        {{ $apartment->bathrooms }}
                                    @else
                                        -
                                    @endif
                                </p>
                                <p>
                                    @if ($apartment->m2)
                                        {{ $apartment->m2 }}
                                    @else
                                        -
                                    @endif
                                </p>
                                <p>
                                    @if ($apartment->is_hidden)
                                        {{ $apartment->is_hidden }}
                                    @else
                                        -
                                    @endif
                                </p>
                                <p>
                                    @if ($apartment->description)
                                        {{ $apartment->description }}
                                    @else
                                        -
                                    @endif
                                </p>
                                <p>
                                    @if ($apartment->address)
                                        {{ $apartment->address }}
                                    @else
                                        -
                                    @endif
                                </p>
                                <p>
                                    @if ($apartment->cover_img_path)
                                        {{ $apartment->cover_img_path }}
                                    @else
                                        -
                                    @endif
                                </p>
                                <p>
                                    @if ($apartment->latitude_int)
                                        {{ $apartment->latitude_int }}
                                    @else
                                        -
                                    @endif
                                </p>
                                <p>
                                    @if ($apartment->longitude_int)
                                        {{ $apartment->longitude_int }}
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                            <div class="card-footer mt-auto">
                                <a href="#" class="btn col-4 btn-primary">EDIT</a>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
