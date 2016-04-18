<?php

namespace Amadeushu\XlsxConverter;

use Illuminate\Support\ServiceProvider;

class XlsxConverterServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot()
  {
    $this->loadViewsFrom(__DIR__ . '/views', 'xlsx-converter');
    if (! $this->app->routesAreCached()) { require __DIR__.'/routes.php'; }
  }

  /**
   * Register the application services.
   *
   * @return void
   */
  public function register()
  {
    // 
  }
}
