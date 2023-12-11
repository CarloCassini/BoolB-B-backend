@extends('layouts.app')

@section('navigation-buttons')
    {{-- per tornare alla dashboard --}}

    <a href="{{ route('admin.home') }}" class="btn btn-style my-3">
        <i class="fa-solid fa-arrow-left me-1"></i>
        Return to Dashboard
    </a>
@endsection

@section('content')
    <div class="container col-12 text-center ">
        <h1 class="my-3 text-center">Apartment {{ $apartment_id }} statistics</h1>
        <div class="my-2 statistics-display ">
            <canvas class="nav-btn-container" id="myChart"></canvas>
        </div>
    </div>
@endsection

{{-- script per visualizzazione grafico --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar', // Tipo di grafico
            data: {
                labels: [
                    @foreach ($visualizationCounts as $data)
                        '{{ date('F Y', mktime(0, 0, 0, $data->month, 1, $data->year)) }}',
                    @endforeach
                ], // Etichette per l'asse x
                datasets: [{
                    label: 'Visualizzazioni',
                    data: [
                        @foreach ($visualizationCounts as $data)
                            {{ $data->count }},
                        @endforeach
                    ], // Dati per le visualizzazioni  
                    backgroundColor: 'rgba(255, 99, 132, 0.2)', // Colore per visualizzazioni
                    borderColor: 'rgba(255, 99, 132, 1)', // Bordo per visualizzazioni
                    borderWidth: 1
                }, {
                    label: 'Messaggi',
                    data: [
                        @foreach ($messageCounts as $data)
                            {{ $data->count }},
                        @endforeach
                    ], // Dati per i messaggi
                    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Colore per messaggi
                    borderColor: 'rgba(54, 162, 235, 1)', // Bordo per messaggi
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true // Inizia dall'asse y da zero
                    }
                }
            }
        });
    });
</script>
