<?php

namespace App\Providers;

use App\Models\Categoria;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrap();
        Schema::defaultStringLength(191);
        $categoria_servicios_all = Categoria::where(['categoria_tipo_id' => 1,'active' => 1])->get();
        $categoria_productos_all = Categoria::where(['categoria_tipo_id' => 2,'active' => 1])->get();
        //return view('comunidad', compact('categoria_servicios_all', 'categoria_productos_all'));
        View::share(compact('categoria_servicios_all', 'categoria_productos_all'));
    }
}
