@extends('layouts.app')

@section('content')
    <div class="container mt-5">

        <h1 class="my-5">
            Apartments List
        </h1>
        <hr>
        {{-- todo da creare la rotta per il create --}}
        <a href="{{ route('admin.apartments.create') }}" class="btn btn-outline-success me-3 py-0">Add new Apartment</a>
        <hr>
        {{-- se esiste almeno un oggetto in apartment --}}
        @if ($apartments[0])
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope='col'>Cover</th>
                        <th scope="col">Title</th>
                        <th scope="col">rooms</th>
                        <th scope="col">beds</th>
                        <th scope="col">bathrooms</th>
                        <th scope="col">m2</th>
                        <th scope='col'>address</th>
                        <th scope='col'>Actions</th>
                        {{-- todo is_hidden must be a btn (as published) --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($apartments as $apartment)
                        <tr>
                            {{-- * id --}}
                            <th scope="row">{{ $apartment->id }}</th>

                            {{-- * image --}}
                            <td>
                                <img src="@if ($apartment->cover_image_path) {{ $apartment->cover_image_path }}@else{{ 'https://via.placeholder.com/200x150.png/333333?tex' }} @endif"
                                    class="img-fluid" alt="cover">
                            </td>

                            {{-- * title --}}
                            <td>{{ $apartment->title }}</td>

                            {{-- * rooms --}}
                            <td>{{ $apartment->rooms }}</td>

                            {{-- * beds --}}
                            <td>{{ $apartment->beds }}</td>

                            {{-- * bathrooms --}}
                            <td>{{ $apartment->bathrooms }}</td>

                            {{-- * m2 --}}
                            <td><span class="text-nowrap">{{ $apartment->m2 }} &#13217</span></td>

                            {{-- * address --}}
                            <td>{{ $apartment->address }}</td>

                            {{-- * actions buttons --}}
                            {{-- todo da creare le rotte corrette --}}

                            <td class="h-100">
                                <div class="h-100 d-flex align-items-center justify-content-between">
                                    <a href="{{ route('admin.apartments.show', $apartment) }}"><i
                                            class="fa-solid fa-eye text-"></i></a>
                                    <a href="{{ route('admin.apartments.edit', $apartment) }}"><i
                                            class="fa-solid fa-pencil text-warning"></i></a>
                                    <a href="#"data-bs-toggle="modal" data-bs-target="#modal-{{ $apartment->id }}"><i
                                            class="fa-solid fa-trash text-danger"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $apartments->links('pagination::bootstrap-5') }}
        @else
            <h1> No Apartments Found :( </h1>
        @endif
    @endsection

    @section('modals')
        {{-- * modals --}}

        @foreach ($apartments as $apartment)
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
                            <p class="text-danger">THIS ACTION IS IRREVERIBLE</p>

                            <hr>

                            <form action="{{ route('admin.apartments.destroy', $apartment) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="send" class="btn btn-outline-danger"><strong>DELETE</strong></button>
                            </form>
                        </div>
                        <div class="modal-footer red-strip"">
                        </div>
                    </div>
                </div>
            </div>
    </div>
    @endforeach
@endsection
