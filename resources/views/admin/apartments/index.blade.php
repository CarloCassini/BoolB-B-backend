@extends('layouts.app')

@section('navigation-buttons')
    <div class="container">
        <h1 class="my-3 text-center">my apartments</h1>
        {{-- go to my appartments list --}}
        <div class="my-5">
            <a href="{{ route('admin.apartments.create') }}" class="btn btn-outline-success me-3 py-0">Add new Apartment</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="container mt-5">

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
                        <th scope='col'>is_hidden</th>
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
                                <img class="img-fluid" alt="cover" {{-- controllo sul src delle immagini (3 possibilità) --}}
                                    src="@if (!$apartment->cover_image_path) https://via.placeholder.com/2000x1500.png/333333?text=Placeholder
                                                        @elseif(Str::startsWith($apartment->cover_image_path, ['http://', 'https://']))
                                                           {{ $apartment->cover_image_path }}
                                                        @else
                                                           {{ asset('/storage/' . $apartment->cover_image_path) }} @endif">
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

                            {{-- * is_hidden --}}
                            <td>
                                @if ($apartment->is_hidden == '0')
                                    <i class="fa-solid fa-square-check text-success"></i>
                                @else
                                    <i class="fa-solid fa-square-xmark text-danger"></i>
                                @endif
                            </td>

                            {{-- * actions buttons --}}
                            {{-- todo da creare le rotte corrette --}}

                            <td class="h-100">
                                <div class="h-100 d-flex align-items-center justify-content-between">

                                    <a href="{{ route('admin.apartments.show', $apartment) }}" class="mx-1"><i
                                            class="fa-solid fa-eye text-primary"></i></a>
                                    <a href="{{ route('admin.apartments.edit', $apartment) }}" class="mx-1"><i
                                            class="fa-solid fa-pencil text-warning"></i></a>
                                    <a href="#" class="mx-1 debug"><i
                                            class="fa-solid fa-chart-simple text-info"></i></a>

                                    {{-- todo xxxxxxxxxxxxxxxxxxxxxxxx --}}
                                    <a href="{{ route('sponsorSelect', $apartment->id) }}" class="mx-1"><i
                                            class="fa-solid fa-money-check-dollar text-success"></i></a>

                                    <a href="#"data-bs-toggle="modal" data-bs-target="#modal-{{ $apartment->id }}"
                                        class="mx-1"><i class="fa-solid fa-trash text-danger"></i></a>
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
    </div>
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
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
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
