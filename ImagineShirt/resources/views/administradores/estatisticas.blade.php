@extends('template.layout', ['dados' => ['active1' => '',
                                        'active2' => '',
                                        'active3' => '',
                                        'active4' => '']]) 

@section('titulo',' | Editar Administrador')

@section('main')

<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Perfil - {{$user->name}}</h4>
                    <div class="breadcrumb__links">
                        <a href="{{ route('root') }}">Página Inicial</a>
                        <a href="{{ route('user', $user) }}">Perfil</a>
                        <span style = "font-weight: bold;">Estatisticas</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<div class="container-fluid mt-5">
    <div class="row mr-5 ml-5">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Encomendas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$orderNum}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Ganhos (Anual)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalSumAno}} €</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Ganhos (Mensal)</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$totalSumMes}} €</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Clientes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$clientCount}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-12 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <h5 class="card-title">Ganhos último ano</h5>
                    <div style="max-height: 400px; overflow-y: auto;">
                        <canvas id="earningsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <script>
            var earningsData = {!! json_encode($earningsData) !!};
            var months = earningsData.map(data => data.month);
            var earnings = earningsData.map(data => data.earnings);

            var ctx2 = document.getElementById('earningsChart').getContext('2d');

            new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Ganhos',
                        data: earnings,
                        backgroundColor: 'rgba(0, 123, 255, 0.1)',
                        borderColor: 'rgba(0, 123, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    layout: {
                        padding: {
                            top: 10,
                            bottom: 10,
                            left: 10,
                            right: 10
                        }
                    }
                }
            });
        </script>

        

        <div class="col-xl-6 col-md-12 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <h5 class="card-title">Distribuição de Usuários</h5>
                    <div class="chart-container" style="max-height: 400px; overflow-y: auto;">
                        <canvas id="userDistributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <script>
            var clientData = {!! json_encode($clientData) !!};
            var labels = clientData.map(data => data.label);
            var percentages = clientData.map(data => data.percentage);

            var ctx = document.getElementById('userDistributionChart').getContext('2d');

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: percentages,
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(255, 205, 86, 0.6)',
                            'rgba(255, 99, 132, 0.6)',
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 205, 86, 1)',
                            'rgba(255, 99, 132, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right'
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var label = context.label || '';

                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed && context.parsed.toFixed) {
                                        label += context.parsed.toFixed(2) + '%';
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        </script>
    </div>
</div>

@endsection
