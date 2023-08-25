<?php

namespace App\Providers;

use App\Models\Categoria;
use App\Models\Categoria_Tipo;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;

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
        $categoria_tipo_all = Categoria_Tipo::get();
        $categoria_all = Categoria::where(['active' => 1])->get();
        foreach ($categoria_all as $categoria) {
            $categoria->icon = Storage::disk('categorias')->url($categoria->icon);
        }
        
        View::share(compact('categoria_tipo_all', 'categoria_all'));
    }
}
