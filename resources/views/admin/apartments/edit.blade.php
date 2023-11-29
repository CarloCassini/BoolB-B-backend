@extends('layouts.app')

@section('navigation-buttons')
    <div class="container">
        <h1 class="my-3 text-center">modifica apartment</h1>
        {{-- per tornare alla index --}}
        <div class=" my-5 d-flex">
            <a href="{{ route('admin.apartments.index') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i>
                Torna alla lista
            </a>

            {{-- per cancellare l'appartamento --}}
            <a href="#"data-bs-toggle="modal" data-bs-target="#modal-{{ $apartment->id }}"
                class="btn btn-outline-danger ms-auto">
                <i class="fa-solid fa-trash text-danger"></i>
                elimina appartamento
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">

        {{-- gestione degli errori --}}
        @if ($errors->any())
            <div class="alert alert-warning">
                <h5>correggi i seguenti errori</h5>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- corpo --}}
        <form action="{{ route('admin.apartments.update', $apartment) }}" method="POST" enctype="multipart/form-data"
            id="form">
            @csrf
            @method('PUT')

            {{-- title --}}
            <h6>i campi con l'* sono obbligatori</h6>
            <div>
                <label for="title" class="form-label">Title*</label>
                <input type="text" name="title" id="title"
                    class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title') ?? $apartment->title }}">
                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- description --}}
            <div class="col-12 mb-4">
                <label for="description" class="form-label">description</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                    rows="5">{{ old('description') ?? $apartment->description }}</textarea>
                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- rooms --}}
            <div>
                <label for="rooms" class="form-label">rooms*</label>
                <input type="number" name="rooms" id="rooms"
                    class="form-control @error('rooms') is-invalid @enderror"
                    value="{{ old('rooms') ?? $apartment->rooms }}">
                @error('rooms')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- beds --}}
            <div>
                <label for="beds" class="form-label">beds*</label>
                <input type="number" name="beds" id="beds" class="form-control @error('beds') is-invalid @enderror"
                    value="{{ old('beds') ?? $apartment->beds }}">
                @error('beds')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- bathrooms --}}
            <div>
                <label for="bathrooms" class="form-label">bathrooms*</label>
                <input type="number" name="bathrooms" id="bathrooms"
                    class="form-control @error('bathrooms') is-invalid @enderror"
                    value="{{ old('bathrooms') ?? $apartment->bathrooms }}">
                @error('bathrooms')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- m2 --}}
            <div>
                <label for="m2" class="form-label">m2*</label>
                <input type="number" name="m2" id="m2" class="form-control @error('m2') is-invalid @enderror"
                    value="{{ old('m2') ?? $apartment->m2 }}">
                @error('m2')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="row my-3">
                {{-- * mi porto dietro i valori dell'appartamento per usarli negli script --}}
                <div class="div d-none">
                    <span
                        id="start-address-full">{{ $apartment->latitude . '|' . $apartment->longitude . '|' . $apartment->address }}</span>
                    <span id="start-address-human">{{ $apartment->address }}</span>
                </div>
                <div class="col-6">
                    <label for="address-txt" class="form-label">address*</label>
                    <input type="text" name="address-txt" id="address"
                        class="form-control @error('address') is-invalid @enderror"
                        value="{{ old('address-txt') ?? $apartment->address }}">
                </div>
                <div class="col-6">
                    <label for="address-select" class="form-label">select from suggestions*</label>
                    <div class="w-100 align-items-end mt-auto">
                        <select class="form-control form-select @error('address') is-invalid @enderror"
                            aria-label="Default select example" name="address-select" id="select-tomtom">
                            {{-- si riempirà con select ad hoc --}}
                        </select>
                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Services  --}}
            <label class="form-label my-3">services</label>

            <div class="form-check @error('tags') is-invalid @enderror p-0">
                <div class="d-flex  flex-wrap">
                    @foreach ($services as $service)
                        <div class="col-3 mt-1">

                            <input type="checkbox" id="service-{{ $service->id }}" value="{{ $service->id }}"
                                name="services[]" class="form-check-control me-2"
                                @if (in_array($service->id, old('services', $apartment_service ?? []))) checked @endif>
                            <label for="service-{{ $service->id }}">
                                <i class="{{ $service->symbol }}"></i> - {{ $service->label }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            @error('services')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            {{-- Cover Image --}}
            <div class="my-3">
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

            {{-- gestione campo is_hidden --}}
            <div class=" form-check @error('is_hidden') is-invalid @enderror p-0">
                <p>does your apartment should be:</p>
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
            @error('is_hidden')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            {{-- todo : gestione delle coordinate di latitudine e longitudine  --}}
            {{-- todo : gestione della cover image ::: è un campo nullable --}}


            <button type="submit" class="btn btn-primary my-3">Salva</button>
        </form>
    </div>
@endsection

@section('modals')
    {{-- * modals --}}
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
    <script>
        const testbutton = document.getElementById("address");
        const select = document.getElementById("select-tomtom");
        let umeroOpzioni = 0;
        let test = 0;

        function callTomtom() {
            let addressToSearch = testbutton.value;
            let apiUri =
                'http://127.0.0.1:8000/api/tomtom/' + addressToSearch;

            axios.get(apiUri).then((response) => {
                select.innerHTML = '';
                for (let i = 0; i < response.data.results.length; i++) {
                    const element = response.data.results[i];

                    var nuovaOpzione = document.createElement('option');

                    // inserisco i valori del campo selezionato in una formattazione particolare che verrà poi gestita dal controller
                    nuovaOpzione.value = element.position.lat + '|' + element.position.lon + '|' +
                        element
                        .address
                        .freeformAddress;

                    nuovaOpzione.text = element.address.freeformAddress
                    nuovaOpzione.id = 'opzione-' + i;


                    select.append(nuovaOpzione);

                }
                numeroOpzioni = response.data.results.length;
                test = 1;
            });
        }
        // ++++++++++++++++++++
        // Aggiungi un gestore di eventi per l'evento "keydown" sulla finestra del documento
        window.addEventListener("keydown", function(event) {
            // Verifica se il tasto premuto è il tasto "Invio"
            if (event.key === "Enter") {
                // Annulla l'evento di invio del modulo
                event.preventDefault();
                callTomtom();
            }
        });
        // ++++++++++++++++++++

        // ++++++++++++++++++++
        // gesione prima valorizzazione select
        const startAddressFull = document.getElementById("start-address-full").innerHTML;
        console.log(startAddressFull);
        const startAddressHuman = document.getElementById("start-address-human").innerHTML;
        var nuovaOpzioneStart = document.createElement('option');

        // inserisco i valori del campo selezionato in una formattazione particolare che verrà poi gestita dal controller
        nuovaOpzioneStart.value = startAddressFull;

        nuovaOpzioneStart.text = startAddressHuman;
        nuovaOpzioneStart.id = 'opzione-start';

        select.append(nuovaOpzioneStart);
        // ++++++++++++++++++++

        testbutton.addEventListener("click", () => {
            select.innerHTML = '';
            test = 0;
        });

        if (test == 0) {
            select.addEventListener("change", () => {
                var selectedOption = select.options[select.selectedIndex];
                testbutton.value = selectedOption.text;
            });
        };

        select.addEventListener("click", () => {
            if (test == 0) {
                callTomtom();
            };

        });
    </script>
@endsection


@section('saa')
    , {
    headers: {
    "Cache-Control": "no-cache",
    "Content-Type": "application/x-www-form-urlencoded",
    "Access-Control-Allow-Origin": "*",
    },
    referrerPolicy: 'no-referrer-when-downgrade'
    }
@endsection
