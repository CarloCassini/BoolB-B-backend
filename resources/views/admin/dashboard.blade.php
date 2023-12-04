@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fs-4 text-secondary my-4">
        {{ __('Dashboard') }}
    </h2>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('User Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    <div class="my-3">
                        <a class="btn btn-primary" href="{{ route('admin.apartments.index') }}">My Apartments</a>
                        <a class=" btn btn-success mx-3"
                        href="{{route('admin.messages')}}">My Messages</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
