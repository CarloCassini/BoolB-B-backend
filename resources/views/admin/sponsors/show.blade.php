@extends('layouts.app')

@section('content')
   {{-- <div class="container">

    {{$sponsor}}
    
    
   </div> --}}

   <div class="card box-shadow mt-0">
      <div class="card-body d-flex flex-column gap-3 py-3">

          {{-- Header --}}
          <div class="container overflow-hidden">
              <div class="d-inline-block text-gradient">
                  <h1>Sponsor</h1>
                  <h2 class="ellipsis mw-100">{{ $apartment->title }}</h2>
              </div>
              <hr class="m-0">
          </div>

          <div class="container">
              @if ($apartment->sponsors()->where('valid', true)->count() > 0)
              You already have a sponsorship :
                  <div>
                      <span>
                          {{ $apartmentSponsor->end_date->format('d/m/y') }}
                      </span>
                      At: <span>{{ $apartmentSponsor->end_date->format('H:i') }}</span>
                  </div>
              @else
                  <p>sponsor</p>
              @endif
          </div>

          <div class="container">
              <form id="payment-form" action="{{ route('admin.process_payment') }}" method="post"
                  class="col-12 col-lg-6 mx-auto">
                  @csrf
                  <div class="card mb-3" style="box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);">
                      <div class="card-body">

                          <div class="form-group">
                              <label for="sponsor_id"
                                  style="font-weight: bold; font-size: 20px; padding-bottom: 1em">Chose a package: </label><br>
                              <div class="row row-cols-1 row-cols-sm-3">
                                  @foreach ($sponsors as $sponsor)
                                      <div>
                                          <div class="form-check">
                                              <input class="form-check-input" type="radio" name="sponsor_id"
                                                  id="sponsor_{{ $sponsor->id }}" value="{{ $sponsor->id }}" required>
                                              <label class="form-check-label" for="sponsor_{{ $sponsor->id }}">
                                                  <h3>{{ $sponsor->name }}</h3>
                                                  <h6>Price: {{ $sponsor->price }}€</h6>
                                                  <h6>Duration:
                                                      {{ $sponsor->duration }}
                                                      hours</h6>
                                              </label>
                                          </div>
                                      </div>
                                  @endforeach
                              </div>

                              {{-- Errore --}}
                              @error('sponsor_id')
                                  <span class="text-danger">{{ $message }}</span>
                              @enderror
                          </div>

                          <div class="form-group mt-3">
                              <select name="apartment_id" id="apartment_id" class="form-control" required
                                  style="display: none">
                                  @foreach ($apartments as $apartment)
                                      <option value="{{ $apartment->id }}">
                                          {{ $apartment->title }}
                                      </option>
                                  @endforeach
                              </select>
                              @error('apartment_id')
                                  <span class="text-danger">{{ $message }}</span>
                              @enderror
                          </div>

                          <div id="dropin-wrapper" class="mt-3">
                              <div id="checkout-message"></div>
                              <div id="dropin-container"></div>
                              <input id="nonce" name="payment_method_nonce" type="hidden" required />
                              <button id="submit-button" class="styled-btn">Pay</button>
                          </div>
                      </div>
                  </div>
              </form>
          </div>

      </div>
  </div>

@endsection

