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
        <form action="{{ route('admin.apartments.store') }}" method="POST" enctype="multipart/form-data" id="form"
            class="needs-validation" novalidate>
            @csrf

            <h6>fields with * are required</h6>

            {{-- title --}}
            <div>
                <label for="title" class="form-label">title</label>
                <input type="text" name="title" id="title"
                    class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                {{-- errore lato client --}}
                <div class="invalid-feedback">
                    title can't be null.
                </div>
                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- description --}}
            <div class="col-12 mb-4">
                <label for="description" class="form-label">description</label>
                <textarea name="description" id="description"
                    class="form-control no-validation @error('description') is-invalid @enderror" rows="5">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="row">
                {{-- rooms --}}
                <div class="col-3">
                    <div>
                        <label for="rooms" class="form-label">rooms*</label>
                        <input type="number" name="rooms" id="rooms"
                            class="form-control @error('rooms') is-invalid @enderror" value="{{ old('rooms') }}"
                            min="1" required>
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
                {{-- beds --}}
                <div class="col-3">
                    <div>
                        <label for="beds" class="form-label">beds*</label>
                        <input type="number" name="beds" id="beds"
                            class="form-control @error('beds') is-invalid @enderror" value="{{ old('beds') }}"
                            min="0" required>
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
                {{-- bathrooms --}}
                <div class="col-3">
                    <div>
                        <label for="bathrooms" class="form-label">bathrooms*</label>
                        <input type="number" name="bathrooms" id="bathrooms"
                            class="form-control @error('bathrooms') is-invalid @enderror" value="{{ old('bathrooms') }}"
                            min="0" required>
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
                {{-- m2 --}}
                <div class="col-3">
                    <div>
                        <label for="m2" class="form-label">m2*</label>
                        <input type="number" name="m2" id="m2"
                            class="form-control @error('m2') is-invalid @enderror" value="{{ old('m2') }}"
                            min="1" required>
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
            </div>

            {{-- address --}}
            <div class="row my-3">
                {{-- todo xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx --}}
                <div class="col-12 ">
                    <label for="address-txt" class="form-label">address*</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                        value="{{ old('address-txt') }}" required id="address-txt">
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
                <input type="text" class=" d-none form-control" value="" name='address' id="address">
            </div>
            {{-- todo xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx --}}

            {{-- Services  --}}

            <label class="form-label my-1 @error('services') is-invalid @enderror" id="services-label">services</label>
            @error('services')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @else
                <div class="invalid-feedback">
                    choose at least one service
                </div>
            @enderror

            <div class="form-check p-0" id="ciccio">
                <div class="d-flex  flex-wrap">
                    @foreach ($services as $service)
                        <div class=" col-12 col-md-4 col-lg-3 mt-1">

                            <input type="checkbox" id="service-{{ $service->id }}" value="{{ $service->id }}"
                                name="services[]" class="form-check-control me-2 check-services"
                                @if (in_array($service->id, old('services', $apartment_service ?? []))) checked @endif>
                            <label for="service-{{ $service->id }}">
                                <i class="{{ $service->symbol }}"></i> - {{ $service->label }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Cover Image --}}
            <div class="my-3">
                <label for="cover_image_path" class="form-label">Cover Image</label>
                <input type="file" name="cover_image_path" id="cover_image_path"
                    class="form-control no-validation @error('cover_image_path') is-invalid @enderror"
                    value="{{ old('cover_image_path') }}">
                @error('cover_image_path')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- gestione campo is_hidden --}}
            <div class=" form-check @error('is_hidden') is-invalid @enderror p-0">
                <p>does your apartment should be:</p>
                <div class="d-flex gap-3">
                    {{-- * il campo è valorizzato di default come visibile. --}}
                    <input type="radio" id="css" name="is_hidden" value="0"
                        @if (old('is_hidden') == '0' || old('is_hidden') == null) checked @endif>
                    <label for="css">visible</label>
                    <input type="radio" id="html" name="is_hidden" value="1"
                        @if (old('is_hidden') == '1') checked @endif>
                    <label for="html">hidden</label>
                </div>
            </div>
            @error('is_hidden')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            {{-- todo : gestione delle coordinate di latitudine e longitudine  --}}

            <button type="submit" class="btn btn-primary my-3">Save</button>
        </form>
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

        function clearSuggestions() {
            const suggerimentiContainer = document.getElementById('suggerimenti');
            suggerimentiContainer.style.display = 'none';
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
