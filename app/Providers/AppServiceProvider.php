<?php

namespace App\Providers;

use App\Models\Categoria;
use App\Models\Categoria_Tipo;

use App\Models\SocialNetwork;
use App\Models\Contact;
use App\Models\Link;
use App\Models\Logo;
use App\Models\Aboutus;
use App\Models\Carrusel;
use App\Models\CategoriaTipo;
use App\Models\Skin;

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
        $logo = Logo::first();
        $logo->image = Storage::disk('logo')->url($logo->image);
        $supercateogrias_all = CategoriaTipo::where(['active' => 1])->get();
        $carrusel_all = Carrusel::where(['active' => 1])->get();
        foreach ($carrusel_all as $carrusel) {
            $carrusel->image = Storage::disk('carrusel')->url($carrusel->image);
        }
        $categoria_all = Categoria::where(['active' => 1])->get();
        foreach ($categoria_all as $categoria) {
            $categoria->icon = Storage::disk('categorias')->url($categoria->icon);
        }
        //$categoria_productos_all = Categoria::where(['categoria_tipo_id' => 2,'active' => 1])->get();
        $socialnetwork_all = SocialNetwork::where('active', 1)->get();
        $contact_all = Contact::where('active',1)->get();
        $link_all = Link::where('active',1)->get();
        $aboutus_all = Aboutus::where('active',1)->paginate(2);
        $skinSelect = Skin::where('active',1)->first();
        $skinSelect->urlskin = Storage::disk('skin')->url($skinSelect->urlskin);
        //return view('comunidad', compact('categoria_servicios_all', 'categoria_productos_all'));
        View::share(compact('categoria_all', 'supercateogrias_all','socialnetwork_all', 'contact_all', 'link_all', 'aboutus_all', 'carrusel_all','logo','skinSelect'));
    }
}
