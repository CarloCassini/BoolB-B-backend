@extends('layouts.app')
@section('navigation-buttons')
    {{-- per tornare alla dashboard --}}

    <a href="{{ route('admin.home') }}" class="btn btn-style my-3">
        <i class="fa-solid fa-arrow-left me-1"></i>
        Return to Dashboard
    </a>
@endsection
@section('content')
    <div class="container d-flex flex-column gap-3 py-3 ">
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


                </thead>
                <tbody>

                    @foreach ($messages as $message)
                        <tr>
                            <td>
                                <div class="d-flex my-1">

                                    <div class="col-3 flex-grow-1 d-none d-md-block">
                                        <img class="img-fluid" alt="cover" {{-- controllo sul src delle immagini (3 possibilità) --}}
                                            src="@if (!$message->cover_image_path) https://via.placeholder.com/2000x1500.png/333333?text=Placeholder
                                        @elseif(Str::startsWith($message->cover_image_path, ['http://', 'https://']))
                                        {{ $message->cover_image_path }}
                                        @else
                                        {{ asset('/storage/' . $message->cover_image_path) }} @endif">
                                    </div>
                                    <div class=" flex-column col-12 col-md-9 ">

                                        <div class=" container d-flex head-message-index align-items-center">
                                            <div class="d-none d-md-block">
                                                <h4>
                                                    {{ $message->title }}
                                                </h4>
                                            </div>
                                            <div class="ms-auto">
                                                <a href="{{ route('admin.apartments.show', $message->apartment_id) }}"
                                                    class="mx-1"><i
                                                        class="fa-solid fa-circle-info text-primary"></i></i></a>
                                                <a href="#"data-bs-toggle="modal"
                                                    data-bs-target="#modal-{{ $message->id }}" class="mx-1"><i
                                                        class="fa-solid fa-trash text-danger"></i></a>
                                            </div>
                                        </div>

                                        <div class="container d-flex flex-column display-message-index ">
                                            <div class="message-info">
                                                @if ($message->name && $message->surname)
                                                    From {{ $message->name }} {{ $message->surname }}
                                                @else
                                                    From Anonymus
                                                @endif

                                            </div>
                                            <div class=" flex-grow-1 p-2">
                                                <div class="message-area"> {{ $message->message }}</div>
                                                <div class="d-flex message-info">
                                                    <div>
                                                        <div class="fw-lighter">
                                                            contact email
                                                        </div>
                                                        <div>
                                                            {{ $message->sender_email }}</div>
                                                    </div>
                                                    <div class=" mt-auto ms-auto">

                                                        <div class="fw-lighter">
                                                            sent at
                                                        </div>
                                                        <div>
                                                            {{ date('d/m/Y', strtotime($message->created_at)) }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
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
