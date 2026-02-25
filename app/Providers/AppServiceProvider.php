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

       $venta = DB::select("
    SELECT
        SUM(venta.pagoTotal) AS tot,
        MONTHNAME(venta.fecha) AS fecha,
        MONTH(venta.fecha) AS fechaN,
        venta.total,
        venta.id_venta
    FROM venta
    WHERE EXTRACT(YEAR FROM fecha) = EXTRACT(YEAR FROM NOW())
    GROUP BY MONTHNAME(venta.fecha)
    ORDER BY MONTH(venta.fecha) ASC
");
$data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

foreach ($venta as $key => $value) {
    $data[$value->fechaN - 1] = $value->tot;
}

    View::share('ventas', $venta);

    }
}
