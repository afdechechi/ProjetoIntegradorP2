<?php

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
Route::get('/', function () {
    return view('welcome');
});

Route::resource('tipoproduto', 'TipoProdutoController');
Route::resource('produto', 'ProdutoController');
Route::resource('endereco', 'EnderecoController');

// Rotas para o Controlador Pedido
Route::get('/pedido', 'PedidoController@index')->name('pedido.index');
Route::post('/pedido/{endereco_id}', 'PedidoController@store')->name('pedido.store');
Route::post('/pedido/enviarPedido/{pedido_id}', 'PedidoController@enviarPedido')->name('pedido.enviarPedido');
Route::post('/pedido/alterarEndereco/{pedido_id}/{endereco_id}', 'PedidoController@alterarEndereco')->name('pedido.alterarEndereco');

//Rotas para o Controlador PedidoProduto
Route::get('/pedidoproduto/getTodosProdutosDeTipo/{produto_id}', 'PedidoProdutoController@getTodosProdutosDeTipo')->name('pedidoproduto.getTodosProdutosDeTipo');
Route::get('/pedidoproduto/getPedidoProdutosList/{pedido_id}', 'PedidoProdutoController@getPedidoProdutosList')->name('pedidoproduto.getPedidoProdutosList');
Route::post('/pedidoproduto/{id_pedido}/{id_produto}/{id_endereco}/{quantidade}', 'PedidoProdutoController@store')->name('pedidoproduto.store');
Route::delete('/pedidoproduto/{id_pedido}/{id_produto}', 'PedidoProdutoController@destroy')->name('pedidoproduto.destroy');
Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
Route::post('/user/logout', 'Auth\LoginController@userLogout')->name('user.logout');

Route::prefix('admin')->group(function () {
    // Dashboard route
    Route::get('/', 'AdminController@index')->name('admin.dashboard');

    // Login routes
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');

    // Logout route
    Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

    // Register routes
    // Route::get('/register', 'Auth\AdminRegisterController@showRegistrationForm')->name('admin.register');
    // Route::post('/register', 'Auth\AdminRegisterController@register')->name('admin.register.submit');

    // Password reset routes
    Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset')->name('admin.password.update');
});


Route::resource('pedidoadm', 'PedidoAdmController');