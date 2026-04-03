@extends('layouts.app')

@section('content')

<div class="px-4 py-2">
    <div class="glass-panel p-4">
        <h2 class="text-center mb-5 mt-2" style="color: var(--accent-color); font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">
            <i class="fas fa-chart-line mr-2"></i> PANEL DE CONTROL
        </h2>

        <div class="container-fluid text-center">
    <div class="row">

        <!--.col-->
        <div class="col-12 mt-4">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-4 col-lg-2-4 mb-3">
                    <article class="statistic-box red">
                        <div class="text-center">
                            <i class="fas fa-users fa-2x mb-2" style="opacity: 0.5;"></i>
                            <div class="number text-light">{{ $total_usuario }}</div>
                            <div class="caption">USUARIOS</div>
                        </div>
                    </article>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-2-4 mb-3">
                    <article class="statistic-box purple">
                        <div class="text-center">
                            <i class="fas fa-user-tie fa-2x mb-2" style="opacity: 0.5;"></i>
                            <div class="number text-light">{{ $total_cliente }}</div>
                            <div class="caption">CLIENTES</div>
                        </div>
                    </article>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-2-4 mb-3">
                    <article class="statistic-box blue">
                        <div class="text-center">
                            <i class="fas fa-tags fa-2x mb-2" style="opacity: 0.5;"></i>
                            <div class="number text-light">{{ $total_categoria }}</div>
                            <div class="caption">CATEGORÍAS</div>
                        </div>
                    </article>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-2-4 mb-3">
                    <article class="statistic-box green">
                        <div class="text-center">
                            <i class="fas fa-shopping-cart fa-2x mb-2" style="opacity: 0.5;"></i>
                            <div class="number text-light">{{ number_format($total_venta, 0) }}</div>
                            <div class="caption">VENTAS HOY</div>
                        </div>
                    </article>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-2-4 mb-3">
                    <article class="statistic-box yellow">
                        <div class="text-center">
                            <i class="fas fa-box-open fa-2x mb-2" style="opacity: 0.5;"></i>
                            <div class="number text-light">{{ $total_producto }}</div>
                            <div class="caption">PRODUCTOS</div>
                        </div>
                    </article>
                </div>
            </div>
            <!--.row-->
        </div>

        <!-- Recent Activity Section -->
        <div class="col-12 mt-4">
            <div class="row">
                <!-- Recent Sales -->
                <div class="col-12 col-lg-6 mb-4">
                    <div class="glass-panel p-4" style="background: rgba(255,255,255,0.02); height: 100%;">
                        <h5 class="mb-4 mt-2 text-center" style="color: var(--accent-color); font-weight: 700; letter-spacing: 1px;">
                            <i class="fas fa-users mr-2"></i> ÚLTIMOS CLIENTES
                        </h5>
                        <div class="table-responsive">
                            <table class="table text-left">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>DNI/DOC</th>
                                        <th>Teléfono</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_clientes as $rc)
                                    <tr>
                                        <td>{{ $rc->nombre }} {{ $rc->apellido }}</td>
                                        <td>{{ $rc->dni }}</td>
                                        <td>{{ $rc->telefono }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recent Entries -->
                <div class="col-12 col-lg-6 mb-4">
                    <div class="glass-panel p-4" style="background: rgba(255,255,255,0.02); height: 100%;">
                        <h5 class="mb-4 mt-2 text-center" style="color: var(--accent-color); font-weight: 700; letter-spacing: 1px;">
                            <i class="fas fa-truck-loading mr-2"></i> ÚLTIMAS ENTRADAS
                        </h5>
                        <div class="table-responsive">
                            <table class="table text-left">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cant.</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_entradas as $re)
                                    <tr>
                                        <td>{{ $re->producto_nombre }}</td>
                                        <td>{{ $re->cantidad }}</td>
                                        <td>{{ date('d/m H:i', strtotime($re->fecha)) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="col-12 mt-2">
            <div class="glass-panel p-4" style="background: rgba(255,255,255,0.01);">
                <h5 class="mb-4 mt-2 text-center" style="color: var(--accent-color); font-weight: 700; letter-spacing: 1px;">
                    <i class="fas fa-chart-area mr-2"></i> GASTOS MENSUALES (ENTRADAS)
                </h5>
                <div style="height: 300px;">
                    <canvas id="grafica"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>

<!--.container-fluid-->
<!--.page-content-->

@push('scripts')
<script>
    let datas = <?php echo json_encode($chart_data); ?>;

    const $grafica = document.querySelector("#grafica");

    const etiquetas = [
        "Enero", "Febrero", "Marzo", "Abril",
        "Mayo", "Junio", "Julio", "Agosto",
        "Septiembre", "Octubre", "Noviembre", "Diciembre"
    ];

    const datosVentas2021 = {
        label: "Gastos $ - <?= date('Y') ?>",
        data: datas,
        backgroundColor: 'rgba(245, 158, 11, 0.4)',
        borderColor: 'rgba(245, 158, 11, 1)',
        borderWidth: 2,
        borderRadius: 5,
        hoverBackgroundColor: 'rgba(245, 158, 11, 0.6)',
    };

    new Chart($grafica, {
        type: 'bar',
        data: {
            labels: etiquetas,
            datasets: [
                datosVentas2021
            ]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontColor: '#94a3b8'
                    },
                    gridLines: {
                        color: 'rgba(255, 255, 255, 0.05)'
                    }
                }],
                xAxes: [{
                    ticks: {
                        fontColor: '#94a3b8'
                    },
                    gridLines: {
                        display: false
                    }
                }]
            },
            legend: {
                labels: {
                    fontColor: '#f8fafc'
                }
            },
            title: {
                display: true,
                text: 'REPORTE MENSUAL DE GASTOS (ENTRADAS)',
                fontColor: '#f59e0b',
                fontSize: 16
            }
        }
    });
</script>
@endpush

@endsection