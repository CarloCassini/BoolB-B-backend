@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header"> Welcome
                    @if (Auth::user()->name)
                        {{ Auth::user()->name }}
                    @else
                        {{ Auth::user()->email }}
                    @endif
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    <div class="my-3">
                        {{-- bottoni --}}
                        <div class="d-flex my-3">
                            <div class="col-4">
                                <div>
                                    <h4>action</h4>
                                </div>
                                <div class="d-flex">
                                    <div>
                                        <a href="{{ route('admin.apartments.create') }}" class="btn btn-success me-3">Add
                                            new Apartment</a>
                                    </div>
                                </div>
                            </div>
                            <div class=" col-8">
                                <div>
                                    <h4>detail pages</h4>
                                </div>
                                <div class="d-flex">
                                    <div>
                                        <a class="btn btn-primary me-3" href="{{ route('admin.apartments.index') }}"> show
                                            My
                                            Apartments</a>
                                    </div>
                                    <div>
                                        <a class="btn btn-primary me-3" href="{{ route('admin.messages.index') }}"> show My
                                            messages</a>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="row row-cols-2 m-0 ">
                {{-- appartamenti --}}
                <nav class="col-12 col-xl-9 navbar navbar-expand-xl ">
                    <button class=" dashboard-menu d-block d-xl-none navbar-toggler" type="button"
                        data-bs-toggle="collapse" data-bs-target="#apartmentMenu" aria-controls="apartmentMenu"
                        aria-expanded="false" aria-label="burgher per apartments">
                        <div class=" d-flex justify-content-between align-items-center">
                            <h3>Apartment table</h3>
                            <span class=" ms-auto"><i class="fa-solid fa-bars fa-xl"></i></span>
                        </div>
                    </button>
                    <div class=" collapse show navbar-collapse" id="apartmentMenu">
                        <div>

                            <div class="overflow-auto overflow-x-hidden dashboard-space m-0">

                                @if ($apartments[0])
                                    <table class="table table-striped table-hover m-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col" class="d-none d-xl-table-cell">cover</th>
                                                <th scope="col">title</th>
                                                <th scope="col" class="d-none d-xl-table-cell">rooms</th>
                                                <th scope="col" class="d-none d-xl-table-cell">beds</th>
                                                <th scope="col" class="d-none d-xl-table-cell">bathrooms</th>
                                                <th scope="col" class="d-none d-xl-table-cell">surface</th>
                                                <th scope='col'>address</th>
                                                <th scope='col'><i class="fa-solid fa-eye"></i></th>
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
                                                    <td class="d-none d-xl-table-cell">
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
                                                    <td class="d-none d-xl-table-cell">{{ $apartment->rooms }}</td>

                                                    {{-- * beds --}}
                                                    <td class="d-none d-xl-table-cell">{{ $apartment->beds }}</td>

                                                    {{-- * bathrooms --}}
                                                    <td class="d-none d-xl-table-cell">{{ $apartment->bathrooms }}</td>

                                                    {{-- * m2 --}}
                                                    <td class="d-none d-xl-table-cell"><span
                                                            class="text-nowrap">{{ $apartment->m2 }} &#13217</span>
                                                    </td>

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
                                                        <div
                                                            class="h-100 d-flex align-items-center justify-content-between">

                                                            <a href="{{ route('admin.apartments.show', $apartment) }}"
                                                                class="mx-1"><i
                                                                    class="fa-solid fa-circle-info text-primary"></i></a>
                                                            <a href="{{ route('admin.apartments.edit', $apartment) }}"
                                                                class="mx-1"><i
                                                                    class="fa-solid fa-pencil text-warning"></i></a>

                                                            <a href="{{ route('show.statistics', $apartment->id) }}"
                                                                class="mx-1"><i
                                                                    class="fa-solid fa-chart-simple text-info"></i></a>

                                                            <a href="{{ route('sponsorSelect', $apartment->id) }}"
                                                                class="mx-1"><i
                                                                    class="fa-solid fa-money-check-dollar text-success"></i></a>

                                                            <a href="#"data-bs-toggle="modal"
                                                                data-bs-target="#modal-{{ $apartment->id }}"
                                                                class="mx-1"><i
                                                                    class="fa-solid fa-trash text-danger"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <h1> No Apartments Found :( </h1>
                                @endif
                            </div>
                            <div class="container dashboard-head overflow-hidden">
                                <div class=" text-gradient">
                                    {{-- se esiste almeno un oggetto in apartment --}}
                                    <div class="my-1 py-2 dashboard-pagination">
                                        {{ $apartments->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                                <hr class="m-0">
                            </div>
                        </div>
                    </div>
                </nav>
                {{-- messaggi --}}
                <nav class="col-12 col-xl-3 navbar navbar-expand-xl ">
                    <button class="dashboard-menu d-block d-xl-none navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#msgMenu" aria-controls="msgMenu" aria-expanded="false"
                        aria-label="burgher per apartments">
                        <div class=" d-flex justify-content-between align-items-center">
                            <h3>messages table</h3>
                            <span class=" ms-auto"><i class="fa-solid fa-bars fa-xl"></i></span>
                        </div>
                    </button>
                    <div class=" collapse navbar-collapse" id="msgMenu">
                        <div>
                            <div class="container dashboard-head overflow-hidden mt-4 ">
                                <div class="d-block text-gradient">
                                    <div class=" dashboard-head d-flex justify-content-between align-items-center">
                                        <h4>My messages</h4>
                                        <a class=" btn btn-primary me-3"
                                            href="{{ route('admin.messages.index') }}">show</a>
                                    </div>
                                </div>
                                <hr class="m-0 mt-auto">
                            </div>
                            <div class="overflow-scroll overflow-x-hidden dashboard-space m-0 ">

                                <table class="table table-striped table-hover">
                                    <tbody>
                                        @foreach ($messages as $message)
                                            <tr>
                                                <td>
                                                    <h4> From {{ $message->name }} {{ $message->surname }}</h4>
                                                    <h5 class="text-gradient m-0 fs-5 fw-4 ellipsis"> e-mail:
                                                        {{ $message->sender_email }} </h5>
                                                    <h6>For apartment {{ $message->apartment_id }}</h6>
                                                    <p class="data text-gradient m-0 fs-6 ellipsis">
                                                        {{ date('d/m/Y', strtotime($message->created_at)) }}
                                                    </p>
                                                    <div class="message-overlay"></div>
                                                </td>
                                                <td>
                                                    <!-- Button trigger modal -->
                                                    <button class=" message-card-btn mt-3 btn-style "
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal{{ $message->id }}">
                                                        Open
                                                    </button>
                                                </td>
                                            </tr>
                                            {{-- @empty
                                                        <div class="message-card-noMessage">
                                                            <p class="message-heading">
                                                                No message for this apartment</p>
                                                        </div> --}}
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </nav>

            </div>

        </div>
    </div>
@endsection

@section('modals')
    {{-- * modals --}}

    {{-- modals di apartments --}}
    <section>
        @foreach ($apartments as $apartment)
            <div class="modal fade" tabindex="-1" id="modal-{{ $apartment->id }}">
                <div class="modal-dialog ">
                    <div class="modal-content">
                        <div class="modal-header red-strip">
                            <h5 class="modal-title">DELETE FROM DATABASE</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
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
    </section>

    {{-- modals di messages --}}
    <section>
        @forelse ($messages as $message)
            <div class="modal fade" id="exampleModal{{ $message->id }}" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content message-card-noMessage p-3">
                        <div class="d-flex justify-content-between">
                            <h2 class="modal-title text-gradient fs-5 fw-3 ellipsis mw-100" id="exampleModalLabel">
                                From:
                                {{ $message->sender_email }}
                            </h2>
                        </div>
                        <div class="py-2">{{ $message->message }}</div>
                        <div class="text-gradient" style="font-size: 12px">
                            Received on

                            {{ date('d/m/Y', strtotime($message->created_at)) }}
                            at
                            {{ date('H:i', strtotime($message->created_at)) }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
        @endforelse
    </section>
@endsection

<style>
    .btn-style {
        background-color: transparent;
        border-radius: 0.5rem;
        border: 1px solid #ff7977;
        color: #ff7977;
        font-weight: 700;
        transition: 1s;
    }

    .btn-style:hover {
        background-color: #ff7977;
        color: #ffffff;
        transform: translate(2px, -2px);
        box-shadow: -3px 3px 10px 1px #222222;
        transition: 0.5s ease-in-out;
    }
</style>
