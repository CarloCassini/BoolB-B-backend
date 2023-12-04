@extends('layouts.app')

@section('content')


<div class="card box-shadow mt-3">
    <div class="card-body d-flex flex-column gap-3 py-3">

        {{-- Header --}}
        <div class="container overflow-hidden">
            <div class="d-inline-block text-gradient">
                <h1>My messages</h1>
            </div>
            <hr class="m-0">
        </div>

        {{-- Messages --}}
        <div class="container">
            <div class="d-flex flex-column gap-3">
                @forelse ($messages as $message)
                    <div class="message-card">
                        <h2> From {{ $message->name }} {{ $message->surname }}</h2>
                        <h3 class="text-gradient m-0 fs-5 fw-4 ellipsis"> e-mail: {{ $message->sender_email }} </h3>
                        <h5>For apartment {{ $message->apartment_id }}</h5>
                        <p class="data text-gradient m-0 fs-6 ellipsis">
                            {{ $message->created_at->format('d/m/y') }}
                        </p>
                        <div class="message-overlay"></div>

                        <!-- Button trigger modal -->
                        <button class="message-card-btn mt-3" data-bs-toggle="modal"
                            data-bs-target="#exampleModal{{ $message->id }}">
                            Open
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{ $message->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content message-card-noMessage p-3">
                                    <div class="d-flex justify-content-between">
                                        <h2 class="modal-title text-gradient fs-5 fw-3 ellipsis mw-100"
                                            id="exampleModalLabel">
                                            From:
                                            {{ $message->sender_email }}
                                        </h2>
                                    </div>
                                    <div class="py-2">{{ $message->message }}</div>
                                    <div class="text-gradient" style="font-size: 12px">
                                        Received on
                                        {{ $message->created_at->format('d/m/y') }}
                                        at
                                        {{ $message->created_at->format('H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="message-card-noMessage">
                        <p class="message-heading">
                            No message for this apartment</p>
                    </div>
                @endforelse
            </div>

        </div>

        {{-- Pagination --}}
        <div class="container">
            
        </div>

    </div>
</div>


@endsection