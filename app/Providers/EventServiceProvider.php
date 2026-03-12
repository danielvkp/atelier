<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Models\Servicio;
use App\Observers\ServicioObserver;

use App\Models\Blog;
use App\Observers\BlogObserver;

use App\Models\Categoria;
use App\Observers\CategoriaObserver;

use App\Models\Seccion;
use App\Observers\SeccionObserver;

use App\Models\Producto;
use App\Observers\ProductoObserver;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    public function boot(): void {
      Servicio::observe(ServicioObserver::class);
      Blog::observe(BlogObserver::class);
      Categoria::observe(CategoriaObserver::class);
      Seccion::observe(SeccionObserver::class);
      Producto::observe(ProductoObserver::class);
    }

    public function shouldDiscoverEvents(): bool {
        return false;
    }
}
