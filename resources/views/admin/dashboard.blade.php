@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
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

                        {{-- <a class=" btn btn-success mx-3" href="{{ route('/messages') }}">My Messages</a> --}}

                        <div class="border my-1 debug">per arrivare qui ho usato la index in
                            http/controllers/admin/pagecontroller</div>
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
            <div class="row row-cols-2 m-0 ">
                {{-- appartamenti --}}
                <div class="col-9 overflow-auto overflow-x-hidden dashboard-space m-0">
                    {{-- se esiste almeno un oggetto in apartment --}}
                    @if ($apartments[0])
                        <div class="my-1 py-2 sticky-top dashboard-pagination">
                            {{ $apartments->links('pagination::bootstrap-5') }}
                        </div>
                        <table class="table table-striped table-hover m-0">
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

                                                <a href="{{ route('admin.apartments.show', $apartment) }}"
                                                    class="mx-1"><i class="fa-solid fa-eye text-primary"></i></a>
                                                <a href="{{ route('admin.apartments.edit', $apartment) }}"
                                                    class="mx-1"><i class="fa-solid fa-pencil text-warning"></i></a>
                                                <a href="#" class="mx-1 debug"><i
                                                        class="fa-solid fa-chart-simple text-info"></i></a>

                                                <a href="{{ route('sponsorSelect', $apartment->id) }}" class="mx-1"><i
                                                        class="fa-solid fa-money-check-dollar text-success"></i></a>

                                                <a href="#"data-bs-toggle="modal"
                                                    data-bs-target="#modal-{{ $apartment->id }}" class="mx-1"><i
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
                {{-- messaggi --}}
                <div class="col-3  overflow-scroll overflow-x-hidden dashboard-space m-0 ">
                    <table class="table table-striped table-hover">
                        <thead>
                            {{-- Header --}}
                            <tr>

                                <div class="container overflow-hidden">
                                    <div class="d-inline-block text-gradient">
                                        <h1>My messages</h1>
                                    </div>
                                    <hr class="m-0">
                                </div>
                            </tr>
                        </thead>
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

                                        <!-- Button trigger modal -->
                                        <button class="message-card-btn mt-3" data-bs-toggle="modal"
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
    </section>

    {{-- modals di messages --}}
    <section>
        @forelse ($messages as $message)
            <div class="modal fade" id="exampleModal{{ $message->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
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
