<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\ClienteController;

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes(['verify' => true]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    // PERFIL
    Route::controller(PerfilController::class)->group(function () {
        Route::get('mi-perfil', 'index')->name('usuario.perfil');
        Route::post('actualizar-foto-perfil', 'actualizarIMG')->name('perfil.actualizarIMG');
        Route::delete('perfil/eliminar-foto', 'eliminarFotoPerfil')->name('perfil.eliminarFotoPerfil');
        Route::post('actualizar-datos-perfil', 'actualizarDatos')->name('perfil.actualizarDatos');
        Route::get('cambiar-clave', 'cambiarClave')->name('usuario.cambiarClave');
        Route::post('actualizar-clave', 'actualizarClave')->name('usuario.actualizarClave');
    });

    // EMPRESA
    Route::controller(EmpresaController::class)->group(function () {
        Route::get('empresa-index', 'index')->name('empresa.index');
        Route::post('empresa-update-{id}', 'update')->name('empresa.update');
        Route::post('actualizar-logo', 'actualizarLogo')->name('empresa.actualizarLogo');
        Route::delete('eliminar-logo', 'eliminarLogo')->name('empresa.eliminarLogo');
    });

    // PRODUCTOS
    Route::resource('productos', ProductoController::class);
    Route::controller(ProductoController::class)->group(function () {
        Route::post("buscar-producto", "buscarProducto")->name("producto.buscar");
        Route::post("registrar-foto-producto", "registrarFotoProducto")->name("producto.registrarFotoProducto");
        Route::get("eliminar-foto-producto-{id}", "eliminarFotoProducto")->name("producto.eliminarFoto");
    });

    // CATEGORÍAS
    Route::resource('categoria', CategoriaController::class);

    // USUARIOS
    Route::resource('usuario', UsuarioController::class);
    Route::controller(UsuarioController::class)->group(function () {
        Route::post("registrar-foto-usuario", "registrarFotoUsuario")->name("usuario.registrarFotoUsuario");
        Route::post("eliminar-foto-usuario", "eliminarFotoUsuario")->name("usuario.eliminarFoto");
    });

    // CLIENTES
    Route::resource('clientes', ClienteController::class);

    // ENTRADAS (Todo en uno)
    Route::resource('entradas', EntradaController::class);
});