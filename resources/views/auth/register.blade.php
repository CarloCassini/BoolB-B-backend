@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <h3>
                            Registrati
                        </h3>
                        <span>registrati al nostro sito mediante questo form di registrazione,</span><br><span> i capi
                            contrassegnati con <strong class="fs-4 text-warning">*</strong> sono obbligatori</span>
                        {{-- form --}}
                        <form method="POST" action="{{ route('register') }}" class="needs-validation my-3" novalidate>
                            @csrf
                            {{-- * name --}}
                            <div class="mb-4 row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control no-validation @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" autocomplete="family-name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- * surname --}}
                            <div class="mb-4 row">
                                <label for="surname"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Surname') }}</label>

                                <div class="col-md-6">
                                    <input id="surname" type="text"
                                        class="form-control no-validation  @error('surname') is-invalid @enderror"
                                        name="surname" value="{{ old('surname') }}" autocomplete="given-name" autofocus>

                                    @error('surname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- * date_of_birth --}}
                            <div class="mb-4 row">
                                <label for="date_of_birth"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Date of birth') }}</label>

                                <div class="col-md-6">
                                    <input id="date_of_birth" type="date"
                                        class="form-control no-validation @error('date_of_birth') is-invalid @enderror"
                                        name="date_of_birth" value="{{ old('date_of_birth') }}" autocomplete="family-name"
                                        autofocus>
                                    <div class="invalid-feedback">
                                        Please insert a valid date.
                                    </div>
                                    @error('date_of_birth')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- * email --}}
                            <div class="mb-4 row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}<strong
                                        class="fs-4 ms-1 text-warning">*</strong></label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">
                                    <div class="invalid-feedback">
                                        Please insert a valid e-mail.
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- * password --}}
                            <div class="mb-4 row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password') }}<strong
                                        class="fs-4 ms-1 text-warning">*</strong></label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">
                                    <div class="invalid-feedback">
                                        Please choose a Password.
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- * password confirm --}}
                            <div class="mb-4 row">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}<strong
                                        class="fs-4 ms-1 text-warning">*</strong></label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                    <div class="invalid-feedback">
                                        Passwords do not match.
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (() => {
            'use strict';

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation');


            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    // Exclude validation for fields with the class 'no-validation'
                    const fieldsToValidate = form.querySelectorAll('.form-control:not(.no-validation)');

                    // Additional check: Verify that password1 matches password2
                    const password1 = form.querySelector(
                        '#password'); // Replace with the actual ID of your first password field
                    const password2 = form.querySelector(
                        '#password-confirm'
                    ); // Replace with the actual ID of your second password field

                    if (password1.value !== password2.value) {
                        // Passwords do not match, prevent form submission
                        password2.setCustomValidity("Passwords must match");
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        password2.setCustomValidity(""); // Reset custom validity
                    }

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
