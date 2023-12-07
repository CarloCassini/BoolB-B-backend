@extends('layouts.app')

@section('content')

<div class="container">

      <form action="{{ route('admin.sponsors.create') }}" method="POST">
        @csrf
    
        <label for="name" class="form-label">Select apartment</label>
        <input type="text" class="form-control" id="name" name="name" />
    
     
    
        <label for="type" class="form-label">Package</label>
        <select class="form-select" id="type" name="type">
            <option value="standard">Standard - 2,99 €</option>
            <option value="gold">Gold - 5,99 €</option>
            <option value="premium">Premium - 9,99 €</option>
        </select>
    
        <label for="img" class="form-label">Terms of payment</label>
        <select class="form-select" id="type" name="type">
          <option value="">Mastercard</option>
          <option value="">Apple-pay</option>
          <option value="">PayPal</option>
      </select>
        
    
        {{-- <label for="description" class="form-label">Descrizione</label>
        <textarea
            class="form-control"
            id="description"
            name="description"
            rows="4"
        ></textarea> --}}
        <button type="submit" class="btn mt-4 btn-primary">Sponsor</button>
      </form>
      
</div>
@endsection