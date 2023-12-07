@extends('layouts.app')
@section('navigation-buttons')
    <div class="container">
        <div class=" my-3 d-flex">
            {{-- per tornare alla dashboard --}}
            <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i>
                Back to Dashboard
            </a>
        </div>
    </div>
@endsection
@section('content')
    <div class="container ">
        <div class="container overflow-hidden">
            <div class="d-inline-block text-gradient">
                <h1>My messages</h1>
            </div>
            <hr class="m-0">
        </div>
        <div class="overflow-auto overflow-x-hidden dashboard-space m-0">

            <table class="table table-striped table-hover">
                <thead>
                    {{-- Header --}}
                    <tr>
                        <th scope="col">detail</th>
                        <th scope='col'>message</th>
                        <th scope="col">action</th>
                    </tr>

                </thead>
                <tbody>

                    @foreach ($messages as $message)
                        <tr>
                            <td class="col-2">
                                @if ($message->name && $message->surname)
                                    <h4> From {{ $message->name }} {{ $message->surname }}
                                    </h4>
                                @else
                                    <h4> From Anonymus
                                    </h4>
                                @endif
                                <h5> {{ $message->sender_email }} </h5>

                                <h5 class="text-gradient m-0 fs-5 fw-4 ellipsis"> e-mail:
                                    <h6>For apartment {{ $message->apartment_id }}</h6>
                                    <p class="data text-gradient m-0 fs-6 ellipsis">
                                        {{ date('d/m/Y', strtotime($message->created_at)) }}
                                    </p>
                                    <div class="message-overlay"></div>

                                    <!-- Button trigger modal -->
                                    {{-- <button class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal{{ $message->id }}">
                                Open
                            </button> --}}

                            </td>
                            <td class="col-8">
                                {{ $message->message }}
                            </td>
                            <td class="col-1">
                                <a href="{{ route('admin.apartments.show', $message->apartment_id) }}" class="mx-1"><i
                                        class="fa-solid fa-eye text-primary"></i></a>
                                <a href="#"data-bs-toggle="modal" data-bs-target="#modal-{{ $message->id }}"
                                    class="mx-1"><i class="fa-solid fa-trash text-danger"></i></a>

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
@endsection

@section('modals')
    {{-- * modals --}}

    {{-- modals di messages  --}}
    {{-- <section>
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
    </section> --}}

    {{-- modals di cancellazione messaggio --}}
    <section>
        @foreach ($messages as $message)
            <div class="modal fade" tabindex="-1" id="modal-{{ $message->id }}">
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
                                    ID :
                                </strong>
                                {{ $message->id }}
                                <br>
                                from the database?
                            </p>
                            <p class="text-danger">THIS ACTION IS IRREVERIBLE</p>

                            <hr>

                            <form action="{{ route('admin.messages.destroy', $message) }}" method="post">
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
@endsection
