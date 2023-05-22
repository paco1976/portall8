<?php

use App\Models\User_type;
use App\Models\User_Cfp;
use App\Models\User_Profile;
use App\Models\User;
use App\Models\Categoria;
use App\Models\Categoria_Tipo;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
*/

Route::get('/', 'PublicController@index')->name('welcome');

Auth::routes();

Route::get('/register', function () {
    $user_type_all = User_type::where('active', 1)->get();
    $user_cfp_all = User_Cfp::where('active', 1)->get();
    return view('auth/register', compact('user_type_all', 'user_cfp_all'));
})->name('register');


//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/perfil', 'UserController@index')->name('perfil');
//rutas para crear el perfil
Route::get('/perfil_new', 'ProfileController@nuevo')->name('perfil_new');
Route::put('/perfil/store', 'ProfileController@store')->name('store');
//rutas para editar el perfil
Route::get('/perfil_edit', 'ProfileController@edit')->name('perfil_edit');
Route::put('/perfil_update', 'ProfileController@update')->name('perfil_update');
Route::get('/avatardelete', 'UserController@avatardelete')->name('avatardelete');
Route::put('/avatarupload', 'UserController@avatarupload')->name('avatarupload');

//panel de control de publicaciones y mesajes del profesional
Route::get('/publicacion_new','PublicacionController@publicacion_new')->name('publicacion_new');
Route::put('/publicacion_new', 'PublicacionController@publicacion_save')->name('publicacion_save');
Route::get('/publicacion','PublicacionController@mispublicaciones' )->name('publicacion');
Route::get('/publicacion_consultas/{publicacion_hash}','PublicacionController@publicacion_consultas' )->name('publicacion_consultas');
Route::get('/publicacion_mensajes/{head_hash}','PublicacionController@publicacion_mensajes' )->name('publicacion_mensajes');
Route::put('/publicacion_mensaje_respuesta/{hash}','PublicacionController@publicacion_mensaje_respuesta' )->name('publicacion_mensaje_respuesta');
Route::get('/publicacion_edit/{publicacion_hash}','PublicacionController@publicacion_edit' )->name('publicacion_edit');
Route::put('/publicacion_update', 'PublicacionController@publicacion_update')->name('publicacion_update');
Route::get('/imagen_delete/{id}', 'PublicacionController@imagen_delete')->name('imagen_delete');
Route::get('/publicacion_delete/{hash}', 'PublicacionController@publicacion_delete')->name('publicacion_delete');


//home y publicaciones sin login
Route::get('/homepublicaciones/{id}','PublicController@publicaciones' )->name('homepublicaciones');
Route::get('/homeprofesional/{id}','PublicController@publicacion_profesional' )->name('homeprofesional');
Route::put('/homeprofesional/{id}', 'PublicController@interaction_publicacion')->name('interaction_publicacion');
Route::get('/homeinteraction/{hash}','PublicController@homeinteraction' )->name('homeinteraction');
Route::put('/homeinteraction/{hash}', 'PublicController@interaction_publicacion_respuesta')->name('interaction_publicacion_respuesta');
//ruta para el formulario de whatsapp
Route::get('/publicacion_whatsapp/{hash}','PublicController@publicacion_whatsapp' )->name('publicacion_whatsapp');
Route::put('/publicacion_whatsapp_save', 'PublicController@publicacion_whatsapp_save')->name('publicacion_whatsapp_save');
//buscador de publicaciones
Route::get('/publicacion_buscar','PublicController@publicacion_buscar' )->name('publicacion_buscar');


//panel de control de referentes
Route::get('/profesionales','ReferenteController@profesionales' )->name('profesionales');
Route::get('/publicaciones','ReferenteController@publicaciones' )->name('publicaciones');
Route::get('/publicacion/{hash}','ReferenteController@publicacion' )->name('referente_publicacion');
Route::get('/publicaciones_user/{user_hash}','ReferenteController@publicaciones_user' )->name('publicaciones_user');
Route::get('/publicacion_user/{publicacion_hash}','ReferenteController@publicacion_user' )->name('publicacion_user');
Route::get('/publicaciones_aprobar_desaprobar/{publicacion_hash}','ReferenteController@publicaciones_aprobar_desaprobar' )->name('publicaciones_aprobar_desaprobar');
Route::get('/user_aprobar_desaprobar/{user_hash}','ReferenteController@user_aprobar_desaprobar' )->name('user_aprobar_desaprobar');
Route::get('/consultas/{publicacion_hash}', 'ReferenteController@consultas')->name('consultas');
Route::get('/mensajes/{hash}', 'ReferenteController@mensajes')->name('mensajes');


//panel de control del administrador general
Route::get('/admin_profesionales','AdminController@admin_profesionales' )->name('admin_profesionales');
Route::get('/admin_publicaciones','AdminController@admin_publicaciones' )->name('admin_publicaciones');
Route::get('/admin_publicacion/{hash}','AdminController@admin_publicacion' )->name('admin_publicacion');
Route::get('/admin_publicaciones_user/{user_hash}','AdminController@admin_publicaciones_user' )->name('admin_publicaciones_user');

Route::get('/admin_publicacion_user/{publicacion_hash}/origen/{origen}','AdminController@admin_publicacion_user' )->name('admin_publicacion_user');
Route::get('/admin_publicacion_delete/{publicacion_hash}/origen/{origen}','AdminController@admin_publicacion_delete' )->name('admin_publicacion_delete');
Route::get('/admin_publicaciones_aprobar_desaprobar/{publicacion_hash}/origen/{origen}','AdminController@admin_publicaciones_aprobar_desaprobar' )->name('admin_publicaciones_aprobar_desaprobar');
Route::get('/admin_user_aprobar_desaprobar/{user_hash}/origen/{origen}','AdminController@admin_user_aprobar_desaprobar' )->name('admin_user_aprobar_desaprobar');
Route::get('/admin_user_delete/{user_hash}/origen/origen/{origen}','AdminController@admin_user_delete' )->name('admin_user_delete');

Route::get('/admin_consultas/{publicacion_hash}', 'AdminController@admin_consultas')->name('admin_consultas');
Route::get('/admin_mensajes/{hash}', 'AdminController@admin_mensajes')->name('admin_mensajes');
Route::get('/admin_categorias','AdminController@admin_categorias' )->name('admin_categorias'); 
Route::get('/admin_categoria_activar_desactivar/{id}','AdminController@admin_categoria_activar_desactivar' )->name('admin_categoria_activar_desactivar');
Route::put('/admin_categoria_icon','AdminController@admin_categoria_icon' )->name('admin_categoria_icon');

Route::get('/admin_visitas/{publicacion_hash}', 'AdminController@admin_visitas')->name('admin_visitas');
Route::get('/admin_whatsapp/{publicacion_hash}', 'AdminController@admin_whatsapp')->name('admin_whatsapp');

Route::get('/register_profesional', 'AdminController@register_profesional')->name('register_profesional'); //registra  profesional desde el panel de admin
Route::post('/create_profesional', 'AdminController@create_profesional')->name('create_profesional'); //Crea al nuevo profesional

Route::get('/pass_prof/{id_prof}', 'AdminController@pass_prof' )->name('pass_prof'); //pantalla contraseña panel admin para cambiar al profesional
Route::put('/pass_prof', 'AdminController@updatepass_prof')->name('updatepass_prof'); //actualiza la clave del profesional

Route::get('/prof_perfil/{hash_user}', 'AdminController@prof_perfil')->name('prof_perfil'); //entrar al perfil de profesional

Route::get('/prof_perfil_edit/{hash_user}', 'AdminController@prof_edit')->name('prof_perfil_edit'); //edita el perfil desde el admin
Route::put('/prof_perfil_update/{hash_user}', 'AdminController@prof_update')->name('prof_perfil_update'); //guarda el perfil desde el admin
Route::get('/prof_avatardelete/{hash_user}', 'AdminController@avatardelete')->name('prof_avatardelete'); //elimina avatar de un profesional desde el admin
Route::put('/prof_avatarupload/{hash_user}', 'AdminController@avatarupload')->name('prof_avatarupload'); //sube avatar de un profesional desde el admin


Route::get('/prof_publicacion_edit/{publicacion_hash}/{hash_user}','AdminController@prof_publicacion_edit' )->name('prof_publicacion_edit');
Route::put('/prof_publicacion_update/{hash_user}', 'AdminController@prof_publicacion_update')->name('prof_publicacion_update'); //guarda la publicación editada
Route::get('/prof_publicacion/{hash_user}','AdminController@prof_publicaciones' )->name('prof_publicacion'); //ve las problicaciones del profesional desde el admin
Route::get('/prof_publicacion_new/{hash_user}','AdminController@prof_publicacion_new')->name('prof_publicacion_new'); //alta de publicación desde el admin
Route::put('/prof_publicacion_new/{hash_user}', 'AdminController@prof_publicacion_save')->name('prof_publicacion_save'); //guardar de publicación desde el admin



//todas rutas estaticas por el momento
Route::get('/tarifario',function(){
    $user_type_all = User_type::all();
    $user_cfp_all = User_Cfp::all();
    if (Auth::user()) {
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user_profile = User_Profile::where('user_id',$user->id)->first();
        //$public_path = public_path();
        //$url = Storage::url($user_profile->photo);
        //$user_profile->photo=$url;
        //dd($user_profile);
        return view('tarifario', compact('user', 'user_type_all', 'user_cfp_all', 'user_profile'));
    }else {
        return view('tarifario', compact('user_type_all', 'user_cfp_all'));
    }
} )->name('tarifario');


Route::get('/beneficios',function(){
    $user_type_all = User_type::all();
    $user_cfp_all = User_Cfp::all();
    if (Auth::user()) {
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user_profile = User_Profile::where('user_id',$user->id)->first();
        //$public_path = public_path();
        //$url = Storage::url($user_profile->photo);
        //$user_profile->photo=$url;
        return view('beneficios', compact('user', 'user_type_all', 'user_cfp_all', 'user_profile'));
    }else {
        return view('beneficios', compact('user_type_all', 'user_cfp_all'));
    }
} )->name('beneficios');


Route::get('/foro',function(){ 
    $user_type_all = User_type::all();
    $user_cfp_all = User_Cfp::all();
    if (Auth::user()) {
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user_profile = User_Profile::where('user_id',$user->id)->first();
        //$public_path = public_path();
        //$url = Storage::url($user_profile->photo);
        //$user_profile->photo=$url;
        return view('foro', compact('user', 'user_type_all', 'user_cfp_all', 'user_profile'));
    }else {
        return view('foro', compact('user_type_all', 'user_cfp_all'));
    }
} )->Name('foro');


Route::get('/interacciones',function(){ 
    $user_type_all = User_type::all();
    $user_cfp_all = User_Cfp::all();
    if (Auth::user()) {
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user_profile = User_Profile::where('user_id',$user->id)->first();
        //$public_path = public_path();
        //$url = Storage::url($user_profile->photo);
        //$user_profile->photo=$url;
        return view('interacciones', compact('user', 'user_type_all', 'user_cfp_all', 'user_profile'));
    }else {
        return view('interacciones', compact('user_type_all', 'user_cfp_all'));
    }
    
} )->name('interacciones');




//pantalla cambio contraseña usuario logueado
Route::get('/clave',function(){
    $user_type_all = User_type::all();
    $user_cfp_all = User_Cfp::all();
    if (Auth::user()) {
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user_profile = User_Profile::where('user_id',$user->id)->first();
        //$public_path = public_path();
        //$url = Storage::url($user_profile->photo);
        //$user_profile->photo=$url;
        return view('clave', compact('user', 'user_type_all', 'user_cfp_all', 'user_profile'));
    }else {
        return view('clave', compact('user_type_all', 'user_cfp_all'));
    }
} )->name('clave');

Route::put('/clave', 'UserController@updatepassword')->name('updatepassword');

/* Rutas provisarias hasta que tenga la base de datos */
/* ruta estatica al archivo ubicado en  resources/views llamado publicaion.blade.php */
//Route::get('/perfil',function(){ return view('perfil'); } )->name('perfil');


Route::get('/foto_especifico',function(){ return view('foro_especifico'); } )->name('foroX');
Route::get('/foro_tema',function(){ return view('foro_tema'); } )->Name('foroT');
Route::get('/chat',function(){ return view('chat'); } )->name('chat');

/* Rutas publicas */
Route::get('/contacto',function(){return view('contacto');})->name('contacto');
Route::put('/contacto', 'PublicController@contact_send')->name('contact_send');
Route::get('/condiciones',function(){return view('condiciones');});
Route::get('/comunidad',function(){return view('comunidad');});

//a partir de acá voy a hacer el panel de referentes



/** Rutas para WhatsApp Api */
Route::get('/whatsapp', [App\Http\Controllers\WhatsappController::class, 'handleWebhook']);
Route::post('/whatsapp', [App\Http\Controllers\WhatsappController::class, 'handleResponse']);