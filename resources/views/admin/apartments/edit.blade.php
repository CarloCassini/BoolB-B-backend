@extends('layouts.app')

@section('navigation-buttons')
    {{-- per tornare alla dashboard --}}

    <a href="{{ route('admin.home') }}" class="btn btn-style my-3">
        <i class="fa-solid fa-arrow-left me-1"></i>
        Return to Dashboard
    </a>
@endsection

@section('content')
    <div class="container">

        {{-- gestione degli errori --}}
        @if ($errors->any())
            <div class="alert alert-warning">
                <h5>correct the following errors</h5>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- corpo --}}
        <form action="{{ route('admin.apartments.update', $apartment) }}" method="POST" enctype="multipart/form-data"
            id="form" class="needs-validation" novalidate>
            @csrf
            @method('PUT')

            <span class="muted">fields with <span class="text-warning">*</span> are required</span>
            <div class="row">

                {{-- * title --}}
                <div class="col-lg-6 col-sm-12 mb-4">

                    <label for="title" class="form-label ">Title <span class="text-warning">*</span></label>
                    <input type="text" name="title" id="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') ?? $apartment->title }}" required>
                    <div class="invalid-feedback">
                        title can't be null.
                    </div>
                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- * address --}}

                {{-- ? mi porto dietro i valori dell'appartamento per usarli negli script --}}
                <div class="div d-none">
                    <span
                        id="start-address-full">{{ $apartment->latitude . '|' . $apartment->longitude . '|' . $apartment->address }}</span>
                    <span id="start-address-human">{{ $apartment->address }}</span>
                </div>

                <div class="col-lg-6 col-sm-12 ">
                    <label for="address-txt" class="form-label">address <span class="text-warning">*</span></label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                        value="{{ old('address-txt') ?? $apartment->address }}" required id="address-txt">
                    <div id="suggerimenti"></div>
                    <div class="invalid-feedback">
                        need to choose a suggestion
                    </div>
                    @error('address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <input type="text" class="d-none form-control" value="" name='address' id="address">

                {{-- * description --}}
                <div class="col-sm-12 col-lg-6 mb-4">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                        rows="6">{{ old('description') ?? $apartment->description }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- * Services  --}}
                <div class="col-lg-6 col-sm-12 mb-4">

                    <label class="form-label my-1  @error('services') is-invalid @enderror" id="services-label">services
                        <span class="text-warning">* (At least one)</span></label>
                    @error('services')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @else
                        <div class="invalid-feedback">
                            choose at least one service
                        </div>
                    @enderror
                    <div class="form-check p-0">
                        <div class="card p-2">

                            <div class="row">
                                @foreach ($services as $service)
                                    <div class="col-lg-6 col-sm-12 mt-1">

                                        <input type="checkbox" id="service-{{ $service->id }}"
                                            value="{{ $service->id }}" name="services[]"
                                            class="form-check-control me-2 check-services"
                                            @if (in_array($service->id, old('services', $apartment_service ?? []))) checked @endif>
                                        <label for="service-{{ $service->id }}">
                                            <i class="{{ $service->symbol }}"></i> - {{ $service->label }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>

                {{-- * rooms --}}
                <div class="col-lg-3 col-sm-12">
                    <div>
                        <label for="rooms" class="form-label">Rooms <span class="text-warning">*</span></label>
                        <input type="number" name="rooms" id="rooms"
                            class="form-control @error('rooms') is-invalid @enderror"
                            value="{{ old('rooms') ?? $apartment->rooms }}" min="1" required>
                        <div class="invalid-feedback">
                            must be a number higher than zero.
                        </div>
                        @error('rooms')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                {{-- * beds --}}
                <div class="col-lg-3 col-sm-12">
                    <div>
                        <label for="beds" class="form-label">Beds <span class="text-warning">*</span></label>
                        <input type="number" name="beds" id="beds"
                            class="form-control @error('beds') is-invalid @enderror"
                            value="{{ old('beds') ?? $apartment->beds }}" min="0" required>
                        <div class="invalid-feedback">
                            must be a number higher or equal zero.
                        </div>
                        @error('beds')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                {{-- * bathrooms --}}
                <div class="col-lg-3 col-sm-12">
                    <div>
                        <label for="bathrooms" class="form-label">Bathrooms <span class="text-warning">*</span></label>
                        <input type="number" name="bathrooms" id="bathrooms"
                            class="form-control @error('bathrooms') is-invalid @enderror"
                            value="{{ old('bathrooms') ?? $apartment->bathrooms }}" min="0" required>
                        <div class="invalid-feedback">
                            must be a number higher or equal zero.
                        </div>
                        @error('bathrooms')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                {{-- * m2 --}}
                <div class="col-lg-3 col-sm-12">
                    <div>
                        <label for="m2" class="form-label">m2 <span class="text-warning">*</span></label>
                        <input type="number" name="m2" id="m2"
                            class="form-control @error('m2') is-invalid @enderror"
                            value="{{ old('m2') ?? $apartment->m2 }}" min="1" required>
                        <div class="invalid-feedback">
                            must be a number higher than zero.
                        </div>
                        @error('m2')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                {{-- * Cover Image --}}
                <div class="my-3 col-12">
                    <label for="cover_image_path" class="form-label">Cover Image</label>
                    <input type="file" name="cover_image_path" id="cover_image_path"
                        class="form-control @error('cover_image_path') is-invalid @enderror"
                        value="{{ old('cover_image_path') }}">
                    @error('cover_image_path')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- * gestione campo is_hidden --}}
                <div class="col-lg-6 col-sm-12">

                    <div class=" form-check @error('is_hidden') is-invalid @enderror p-0">
                        <p>Your apartment should be: <span class="text-warning">*</span></p>
                        <div class="nav-btn-container p-1 ps-3">

                            <div class="d-flex gap-3">
                                @if (old('is_hidden') != null)
                                    <input type="radio" id="css" name="is_hidden" value="0"
                                        @if (old('is_hidden') == '0') checked @endif>
                                    <label for="css">visible</label>
                                    <input type="radio" id="html" name="is_hidden" value="1"
                                        @if (old('is_hidden') == '1') checked @endif>
                                    <label for="html">hidden</label>
                                @else
                                    <input type="radio" id="css" name="is_hidden" value="0"
                                        @if ($apartment->is_hidden == '0') checked @endif>
                                    <label for="css">visible</label>
                                    <input type="radio" id="html" name="is_hidden" value="1"
                                        @if ($apartment->is_hidden == '1') checked @endif>
                                    <label for="html">hidden</label>
                                @endif
                            </div>
                        </div>
                    </div>
                    @error('is_hidden')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="nav-btn-container">

                        <div class="d-flex justify-content-between">

                            <a href="#"data-bs-toggle="modal" data-bs-target="#modal-{{ $apartment->id }}"
                                class="btn btn-style my-3">
                                <i class="fa-solid fa-trash text-danger"></i>
                                delete apartment
                            </a>

                            <button type="submit" class="btn btn-style my-3">Save</button>
                        </div>

                    </div>
                </div>
            </div>







        </form>
    </div>
@endsection

@section('modals')
    {{-- * modals --}}
    <div class="modal fade row row-cols-1 row-cols-md-2 row-cols-lg-4 g-2 mt-0" tabindex="-1"
        id="modal-{{ $apartment->id }}">
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
                    <p class="text-danger">THIS ACTION IS IRREVERSIBLE</p>

                    <hr>

                    <form action="{{ route('admin.apartments.destroy', $apartment) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="send" class="btn btn-outline-danger"><strong>DELETE</strong></button>
                    </form>
                </div>
                <div class="modal-footer red-strip">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- per gestione dell'indirizzo --}}
    <script>
        const typeAddress = document.getElementById("address-txt");
        const searchLengthStart = 4;

        // ++++++++++++++++++++
        // Aggiungi un gestore di eventi per l'evento "keydown" sulla finestra del documento
        window.addEventListener("keydown", function(event) {
            // Verifica se il tasto premuto è il tasto "Invio"
            if (event.key === "Enter") {
                // Annulla l'evento di invio del modulo
                event.preventDefault();
                showSuggestions(typeAddress.value);
            }
        });
        // ++++++++++++++++++++

        // ++++++++++++++++++++
        // gesione prima valorizzazione campo suggest_all
        const startAddress_Full = document.getElementById("start-address-full").innerHTML;
        const startAddress_Human = document.getElementById("start-address-human").innerHTML;
        const start_value = document.getElementById("address");

        // inserisco i valori del campo selezionato in una formattazione particolare che verrà poi gestita dal controller
        start_value.value = startAddress_Full;
        // ++++++++++++++++++++


        typeAddress.addEventListener("input", () => {
            if (typeAddress.value.length >= searchLengthStart) {
                showSuggestions(typeAddress.value);
            }
        });

        function showSuggestions(keyword) {
            let addressToSearch = typeAddress.value;
            let apiUri =
                'http://localhost:8000/api/tomtom/' + keyword;

            axios.get(apiUri).then((response) => {
                let suggerimenti = [];
                for (let i = 0; i < response.data.results.length; i++) {
                    const element = response.data.results[i];

                    // inserisco i valori del campo selezionato in una formattazione particolare che verrà poi gestita dal controller
                    const suggerimento_all = element.position.lat + '|' + element.position.lon + '|' +
                        element
                        .address
                        .freeformAddress;
                    const suggerimento_human = element.address.freeformAddress;

                    suggerimenti.push({
                        sugg_all: suggerimento_all,
                        sugg_human: suggerimento_human
                    });

                    const suggerimentiContainer = document.getElementById('suggerimenti');
                    suggerimentiContainer.innerHTML = ''; // Pulisci la lista dei suggerimenti

                    if (keyword.length === 0) {
                        suggerimentiContainer.style.display =
                            'none'; // Nascondi la lista se la barra di ricerca è vuota
                        return;
                    }

                    // +++++++++++++ verifico che una almeno una parola sia presente nell'indirizzo
                    function autocompleteMatch(valore) {
                        if (valore == '') return []
                        const reg = new RegExp(valore);
                        return indirizzoEsploso.filter(indirizzo => {
                            if (indirizzo.match(reg)) return indirizzo
                        })
                    }
                    // xxx
                    let indirizzoEsploso = keyword.toLowerCase().split(' ');
                    let filteredSuggestions = [];
                    suggerimenti.forEach(suggerimento => {
                        let valorePresente = autocompleteMatch(suggerimento.sugg_human
                            .toLowerCase());

                        if (valorePresente) {
                            filteredSuggestions.push(suggerimento);
                        } else {
                            console.log('ritenta');
                        }

                    });
                    // ++++++++++++++++++++++++++++++++++++


                    if (filteredSuggestions.length === 0) {
                        suggerimentiContainer.style.display = 'none';
                        return;
                    }

                    // Aggiungi i suggerimenti filtrati alla lista
                    const suggerimentiList = document.createElement('ul');
                    filteredSuggestions.forEach(suggerimento => {
                        const suggerimentoItem = document.createElement('li');
                        suggerimentoItem.textContent = suggerimento.sugg_human;
                        suggerimentoItem.addEventListener('click', () => {
                            document.getElementById('address-txt').value = suggerimento.sugg_human;
                            document.getElementById('address').value = suggerimento.sugg_all;
                            suggerimentiContainer.style.display = 'none';
                        });
                        suggerimentiList.appendChild(suggerimentoItem);
                    });

                    suggerimentiContainer.appendChild(suggerimentiList);
                    suggerimentiContainer.style.display = 'block';

                }
            });
        }
    </script>

    {{-- scripts per la validazione lato client --}}
    <script>
        (() => {
            'use strict';
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation');

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {

                    // Exclude validation for fields with the class 'no-validation'
                    const fieldsCheck = form.querySelectorAll('.check-services');

                    // verifico che almeno un servizio sia stato selezionato
                    const servicesLabel = form.querySelector('#services-label');
                    let flagServices = false;
                    Array.from(fieldsCheck).forEach(field => {
                        if (field.checked) {
                            flagServices = true;
                        }
                    });
                    if (!flagServices) {
                        servicesLabel.classList.add("is-invalid");
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    // stop contorllo servizi

                    const fieldsToValidate = form.querySelectorAll('.form-control:not(.no-validation)');
                    Array.from(fieldsToValidate).forEach(field => {
                        if (!field.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                    });

                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
@endsection
