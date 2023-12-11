@extends('layouts.app')

@section('navigation-buttons')
@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif
<a href="{{ route('admin.apartments.create') }}" class="btn btn-style my-3 me-3">Add
    new Apartment</a>
<a class="btn btn-style my-3 me-3" href="{{ route('admin.apartments.index') }}"> 
    show
    My
    Apartments
</a>
<a class="text-decoration-none btn btn-style my-3 me-3" href="{{ route('admin.messages.index') }}">
    My Messages
</a>
@endsection
@section('content')
    
        <div class="container">
            <div class="row">
                {{-- * User Apartments --}}
                
                <div class="col-lg-7 col-sm-12">
                    <div class="dashboard-container">

                        @if ($apartments[0])
                            @foreach ($apartments as $apartment)                    
                                <div class="card mb-3" {{-- @if($apartment->is_hidden) data-bs-theme="dark" @endif --}}>
                                    <div class="row g-0">
                                        {{-- * image --}}
                                        <div class="col-md-4">
                                          <img class="img-fluid rounded-start" alt="cover" {{-- controllo sul src delle immagini (3 possibilità) --}}
                                              src="@if (!$apartment->cover_image_path) https://via.placeholder.com/2000x1500.png/333333?text=Placeholder
                                              @elseif(Str::startsWith($apartment->cover_image_path, ['http://', 'https://']))
                                                 {{ $apartment->cover_image_path }}
                                              @else
                                                 {{ asset('/storage/' . $apartment->cover_image_path) }} @endif">
                                        </div>
                                        {{-- * apartment data --}}
                                        <div class="col-md-8">
                                            <div class="card-body">
                                              {{-- * title + id --}}
                                              <div class="d-flex justify-content-between">
                                                  <h5 class="card-title">{{ $apartment->title }}</h5>
                                                  <h5 class="logo-txt">{{ $apartment->id }}</h5>
                                              </div>
                                              <div class="row">
                                                  {{-- * Rooms --}}
                                                  <div class="col-4">
                                                          <strong>
                                                              Rooms
                                                          </strong>
                                                      {{ $apartment->rooms }}
                                                  </div>
                                                  {{-- * Beds --}}
                                                  <div class="col-4">
                                                          <strong>
                                                              Beds
                                                          </strong>
                                                      {{ $apartment->beds }}
                                                  </div>
                                                  {{-- * Bathrooms --}}
                                                <div class="col-4">
                                                        <strong>
                                                            Bathrooms
                                                        </strong>
                                                    {{ $apartment->bathrooms }}
                                                </div>
                                                {{-- * Surface --}}
                                                <div class="col-4">
                                                    <strong>
                                                        Surface
                                                    </strong>
                                                    {{ $apartment->m2 }} &#13217
                                                </div>
                                                {{-- * Visibile --}}
                                                <div class="col-4">
                                                    <strong>
                                                        Visibile
                                                    </strong>
                                                    @if ($apartment->is_hidden == '0')
                                                    <i class="fa-solid fa-square-check text-success"></i>
                                                    @else
                                                        <i class="fa-solid fa-square-xmark text-danger"></i>
                                                    @endif
                                                
                                                </div>
                                                {{-- * Edit --}}
                                                </div>
                                                <div class="d-fle justify-content-between">
                                                    <a href="{{ route('admin.apartments.show', $apartment) }}" class="text-decoration-none btn btn-style">
                                                        <i class="fa-solid fa-eye"></i>
                                                            {{-- View --}}
                                                    </a>
                                                    <a href="{{ route('admin.apartments.edit', $apartment) }}" class="mx-1 btn btn-style">
                                                        <i class="fa-solid fa-pencil"></i>
                                                            {{-- Edit --}}
                                                    </a>
                                                    <a href="{{ route('show.statistics', $apartment->id) }}" class="mx-1 btn btn-style">
                                                        <i class="fa-solid fa-chart-simple"></i>
                                                            {{-- Stats --}}
                                                    </a>
                                                    <a href="{{ route('sponsorSelect', $apartment->id) }}"class="mx-1 btn btn-style">
                                                        <i class="fa-solid fa-money-check-dollar "></i>
                                                            {{-- Sponsor --}}
                                                    </a>
                                                    <a href="#"data-bs-toggle="modal"data-bs-target="#modal-{{ $apartment->id }}"class="mx-1 btn btn-style">
                                                        <i class="fa-solid fa-trash"></i>
                                                            {{-- Delete --}}
                                                    </a>
                                               {{--      <a class="btn btn-style my-3 me-3" href="{{ route('admin.apartments.messages.index',$apartment->id) }}"> show My
                                                        messages
                                                    </a> --}}
                                                </div>
                                                {{-- * address --}}
                                                <p class="card-text"><small class="text-body-secondary">{{ $apartment->address }}</small></p>
                                            </div>
                                        </div>
    
                                    </div>
    
                                </div>
                            @endforeach
                        @else
                            <h1> No Apartments Found :( </h1>
                        @endif
                        {{ $apartments->links('pagination::bootstrap-5') }}

                    </div>
                    
                </div>

                {{-- * User Last Messages --}}

                <div class="col-lg-5 col-sm-12">
                    <div class="dashboard-container">

                    @foreach ($messages as $message)
                    <a class="text-decoration-none" href="{{ route('admin.messages.index') }}">
                        <div class="card mb-3">
                            <div class="card-header d-flex justify-content-between">
                                <div>

                                    <span class="logo-txt">New Message</span> for: {{ $message->apartment_id }}
                                </div>
                                <div>
                                    From: {{ $message->name }} {{ $message->surname }}
                                </div>
                            </div>
                            <div class="card-body">
                                <span class="preview-msg">
                                    {{ strlen($message->message) > 30 ? substr($message->message, 0, 30) . '...' : $message->message }}
                                </span>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <div>
                                    {{ date('d/m/Y', strtotime($message->created_at)) }} 
                                </div>
                                <div>
                                    reply to: {{ $message->sender_email }}
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                    </div>
                </div>
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
