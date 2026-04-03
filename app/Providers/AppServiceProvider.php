<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $total_usuario=DB::select("select count(*) as total from usuario where estado=1");
        View::share('total_usuario', $total_usuario[0]->total);

        $total_cliente=DB::select("select count(*) as total from cliente");
        View::share('total_cliente', $total_cliente[0]->total);

        $total_venta=DB::select("select sum(total) as total from venta where estado=1 and fecha=curdate()");
        View::share('total_venta', $total_venta[0]->total);

        $total_producto=DB::select("select count(*) as total from producto where estado=1");
        View::share('total_producto', $total_producto[0]->total);

        $total_categoria=DB::select("select count(*) as total from categoria");
        View::share('total_categoria', $total_categoria[0]->total);

        // Fetch Recent Entries (Ultimas Entradas)
        $recent_entradas = DB::select("
            SELECT e.*, p.nombre as producto_nombre 
            FROM entrada e 
            JOIN producto p ON e.id_producto = p.id_producto 
            ORDER BY e.fecha DESC LIMIT 5
        ");
        View::share('recent_entradas', $recent_entradas);

        // Fetch Recent Clients (Ultimos Clientes)
        $recent_clientes = DB::select("
            SELECT * 
            FROM cliente 
            ORDER BY id_cliente DESC LIMIT 5
        ");
        View::share('recent_clientes', $recent_clientes);

       $entradas_mensuales = DB::select("
    SELECT
        SUM(precio * cantidad) AS tot,
        MONTHNAME(fecha) AS fecha,
        MONTH(fecha) AS fechaN
    FROM entrada
    WHERE EXTRACT(YEAR FROM fecha) = EXTRACT(YEAR FROM NOW())
    GROUP BY MONTHNAME(fecha), MONTH(fecha)
    ORDER BY MONTH(fecha) ASC
");
$data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

foreach ($entradas_mensuales as $key => $value) {
    // Array indices are 0-11, so we subtract 1 from the month number
    // We make sure it's cast to float for JSON encoding
    $data[(int)$value->fechaN - 1] = (float)$value->tot;
}

    View::share('chart_data', $data);

    }
}
