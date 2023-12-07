@extends('layouts.app')

@section('navigation-buttons')
    <section class="container mt-5 debug text-center">
        iserire testo
        <i class="fa-solid fa-poo fa-bounce fa-2xl"></i>
    </section>

    <div class="container">
        <h1 class="my-3 text-center">Your homepage</h1>
        {{-- go to my appartments list --}}
        @if (Auth::user())
            <div>
                <a href="{{ route('admin.apartments.index') }}" class="btn btn-outline-success me-3 py-0">
                    My Apartments</a>
            </div>
        @endif
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
                        <th scope='col'>Actions</th>
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

                            {{-- * actions buttons --}}
                            <td class="h-100">
                                <div class="h-100 d-flex align-items-center justify-content-center">
                                    <a href="{{ route('guest.apartments.show', $apartment) }}">
                                        <i class="fa-solid fa-eye fa-2xl"></i></a>
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
