@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i>
            Torna alla Dashboard
        </a>
        <h1 class="my-3 text-center">Apartment {{ $apartment_id }} statistics</h1>
        <div class="my-2">
            <canvas id="myChart" width="400" height="150"></canvas>
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
                labels: ['Visualizzazioni', 'Messaggi'], // Etichette per l'asse x
                datasets: [{
                    label: 'numero',
                    data: [{{ $visualizationCount }},
                        {{ $messageCount }}
                    ], // Dati per le statistiche 
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)', // Colore per visualizzazioni
                        'rgba(54, 162, 235, 0.2)', // Colore per messaggi
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)', // Bordo per visualizzazioni
                        'rgba(54, 162, 235, 1)', // Bordo per messaggi
                    ],
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
