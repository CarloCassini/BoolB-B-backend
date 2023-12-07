@extends('layouts.app')

@section('head-scripts')
    <script src="https://js.braintreegateway.com/web/dropin/1.40.2/js/dropin.min.js"></script>
@endsection

@section('content')
    <div class="card mt-0 box-shadow">
        <div class="card-body d-flex flex-column gap-3 py-3">

            {{-- Header --}}
            <div class="container">
                <div class="d-inline-block text-gradient">
                    <h1>Sponsor Apartments</h1>
                </div>

                <div class="container mt-2">
                    <p> Reach a large audience for your apartment with a tailor-made sponsorship! We offer
                        a
                        variety
                        Of
                        sponsorship options, both standard and customized, to best suit yours
                        needs.
                        Choose
                        the ideal solution to promote your apartment and attract the maximum number of potential people
                        clients!
                    </p>
                </div>
                <div class="container">
                    <form action="{{ route('sponsorship') }}" method="POST" class="col-12 col-lg-6 mx-auto" id="payment-form">
                        @csrf
                        <div class="card mb-3" style="box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);">
                            <div class="card-body">
                                <h2 class="card-title">Buy a sponsorship</h2>
                                <div class="form-group">
                                    <label for="sponsor_id">Choose a package:</label><br>
                                    @foreach ($sponsors as $sponsor)
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="radio" name="sponsor_id"
                                                id="sponsor_{{ $sponsor->id }}" value="{{ $sponsor->id }}" required>
                                            <label class="form-check-label" for="sponsor_{{ $sponsor->id }}">
                                                {{ $sponsor->name }} (Price: {{ $sponsor->price }}€, Duration:
                                                {{ $sponsor->time }}
                                                hours)
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <input type="text" name="apartment_id" value="{{ $apartment_id }}" class="d-none">
                                {{-- <div class="debug" id="dropin-wrapper" class="mt-3">
                                    <div id="checkout-message"></div>
                                    <div id="dropin-container"></div>
                                    <button id="submit-button" class="btn btn-primary btn-block">Paga</button>
                                </div> --}}
                            </div>
                        </div>
                        {{-- <button id="submit-button" class="btn btn-primary btn-block">Paga</button> --}}
                        <div class="debug" id="dropin-wrapper" class="mt-3">
                            <div id="checkout-message"></div>
                            <div id="dropin-container"></div>
                            <input type="hidden" id="nonce" name="payment_method_nonce" />
                            <button id="submit-button" class="btn btn-primary btn-block">Pay</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="debug container">
        <div class="debug">https://www.youtube.com/watch?v=kJ4X4Y1IWzA</div>
        <div class="debug">https://www.youtube.com/watch?v=1-Ge9IqbwNY</div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        // let button = document.querySelector('#submit-button');
        // braintree.dropin.create({
        //     authorization: 'sandbox_fw47smcq_t2zvx4dq3yfyv9z3',
        //     selector: '#dropin-container'
        // }, function(err, instance) {
        //     button.addEventListener('click', function() {
        //         instance.requestPaymentMethod().then((payload) => {
        //             // Step four: when the user is ready to complete their
        //             //   transaction, use the dropinInstance to get a payment
        //             //   method nonce for the user's selected payment method, then add
        //             //   it a the hidden field before submitting the complete form to
        //             //   a server-side integration
        //             console.log('PAYLOAD: ' + payload);
        //             event.preventDefault();
        //             document.getElementById('nonce').value = payload.nonce;
        //             // form.submit();
        //         }).catch((error) => {
        //             throw error;
        //         });
        //     });
        // });

        const form = document.getElementById('payment-form');

        braintree.dropin.create({
            authorization: 'sandbox_fw47smcq_t2zvx4dq3yfyv9z3',
            selector: '#dropin-container'
        }).then((dropinInstance) => {
            form.addEventListener('submit', (event) => {
                event.preventDefault();

                dropinInstance.requestPaymentMethod().then((payload) => {
                    // Step four: when the user is ready to complete their
                    //   transaction, use the dropinInstance to get a payment
                    //   method nonce for the user's selected payment method, then add
                    //   it a the hidden field before submitting the complete form to
                    //   a server-side integration
                    document.getElementById('nonce').value = payload.nonce;
                    form.submit();
                }).catch((error) => {
                    throw error;
                });
            });
        }).catch((error) => {
            // handle errors
        });
    </script>
@endsection
