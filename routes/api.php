<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiControllers\AuthController;
use App\Http\Controllers\ApiControllers\ServicioController;
use App\Http\Controllers\ApiControllers\ServicioTarifaController;
use App\Http\Controllers\ApiControllers\TarifaController;
use App\Http\Controllers\ApiControllers\TestimonialController;
use App\Http\Controllers\ApiControllers\CategoriaController;
use App\Http\Controllers\ApiControllers\BlogController;
use App\Http\Controllers\ApiControllers\LegalController;
use App\Http\Controllers\ApiControllers\ReservaController;
use App\Http\Controllers\ApiControllers\SeccionController;
use App\Http\Controllers\ApiControllers\ProductoController;
use App\Http\Controllers\ApiControllers\PaymentController;
use App\Http\Controllers\ApiControllers\EnlacesPagoController;
use App\Http\Controllers\ApiControllers\EmpleadoController;
use App\Http\Controllers\BotController;

Route::post('scrap/{slug}', [BotController::class, 'scrap']);
Route::get('get-links', [BotController::class, 'getBlogs']);

Route::post('login', [AuthController::class, 'login']);

Route::post('recover-password', [UserController::class, 'restorePassword']);

Route::middleware(['auth:sanctum'])->group(function (){
  Route::post('logout', [AuthController::class, 'logout']);

  /*servicios*/
  Route::get('get-servicios', [ServicioController::class, 'all']);
  Route::get('get-servicio/{id}', [ServicioController::class, 'get']);
  Route::post('save-servicio', [ServicioController::class, 'save']);
  Route::get('delete-servicio/{id}', [ServicioController::class, 'trash']);

  /*servicios tarifa*/
  Route::get('get-tarifas-servicios', [ServicioTarifaController::class, 'all']);
  Route::get('get-tarifas-servicio/{id}', [ServicioTarifaController::class, 'get']);
  //Route::get('get-servicio/{id}', [ServicioController::class, 'get']);
  Route::post('save-tarifa-servicio/{id}', [ServicioTarifaController::class, 'save']);
  Route::get('delete-tarifa-servicio/{id}', [ServicioTarifaController::class, 'trash']);

  /*tarifa*/
  Route::get('get-tarifas', [TarifaController::class, 'all']);
  Route::get('get-tarifa/{id}', [TarifaController::class, 'get']);
  Route::post('save-tarifa', [TarifaController::class, 'save']);
  Route::get('delete-tarifa/{id}', [TarifaController::class, 'trash']);

  /*testimonial*/
  Route::get('get-testimonials', [TestimonialController::class, 'all']);
  Route::get('get-testimonial/{id}', [TestimonialController::class, 'get']);
  Route::post('save-testimonial', [TestimonialController::class, 'save']);
  Route::get('delete-testimonial/{id}', [TestimonialController::class, 'trash']);

  /*categoria*/
  Route::get('get-categorias', [CategoriaController::class, 'all']);
  Route::get('get-categoria/{id}', [CategoriaController::class, 'get']);
  Route::post('save-categoria', [CategoriaController::class, 'save']);
  Route::get('delete-categoria/{id}', [CategoriaController::class, 'trash']);

  /*blog*/
  Route::get('get-blogs', [BlogController::class, 'all']);
  Route::get('get-blog/{id}', [BlogController::class, 'get']);
  Route::post('save-blog', [BlogController::class, 'save']);
  Route::get('delete-blog/{id}', [BlogController::class, 'trash']);

  /*legal*/
  Route::get('get-legal', [LegalController::class, 'get']);
  Route::post('save-legal', [LegalController::class, 'save']);

  /*reservas*/
  Route::get('get-reservas', [ReservaController::class, 'get']);
  Route::get('delete-reserva/{id}', [ReservaController::class, 'delete_reserva']);
  Route::post('update-reserva/{id}', [ReservaController::class, 'update']);
  Route::post('save-reserva', [ReservaController::class, 'save']);

  /*secciones*/
  Route::get('get-secciones', [SeccionController::class, 'all']);
  Route::get('get-seccion/{id}', [SeccionController::class, 'get']);
  Route::post('save-seccion', [SeccionController::class, 'save']);
  Route::get('delete-seccion/{id}', [SeccionController::class, 'trash']);

  /*productos*/
  Route::get('get-productos', [ProductoController::class, 'all']);
  Route::get('get-producto/{id}', [ProductoController::class, 'get']);
  Route::post('save-producto', [ProductoController::class, 'save']);
  Route::get('delete-producto/{id}', [ProductoController::class, 'trash']);

  /*payments*/
  Route::post('get-payments', [PaymentController::class, 'all']);
  Route::post('generate-excel', [PaymentController::class, 'generate']);

  /* enlaces de pago */
  Route::get('get-enlaces', [EnlacesPagoController::class, 'all']);
  Route::post('save-enlace', [EnlacesPagoController::class, 'save']);
  Route::get('delete-enlace/{id}', [EnlacesPagoController::class, 'trash']);

  /* empleados */
  Route::get('get-empleados', [EmpleadoController::class, 'all']);
  Route::post('save-empleado', [EmpleadoController::class, 'save']);
  Route::get('delete-empleado/{id}', [EmpleadoController::class, 'trash']);
});
