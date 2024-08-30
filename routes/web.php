<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\BankAccountController;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->post('/conta', ['middleware' => ['log'], 'uses' => 'BankAccountController@store']);
$router->get('/conta', ['middleware' => ['log'], 'uses' => 'BankAccountController@show']);
$router->post('/transacao', ['middleware' => ['log'], 'uses' => 'BankAccountController@update']);