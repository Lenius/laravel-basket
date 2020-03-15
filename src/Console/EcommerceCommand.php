<?php

namespace Lenius\LaravelBasket\Console;

use Illuminate\Console\Command;

class EcommerceCommand extends Command
{
    /**
     * The views that need to be exported.
     *
     * @var array
     */
    protected $views = [
        'ecommerce/basket.stub'   => 'ecommerce/basket.blade.php',
        'ecommerce/product.stub'  => 'ecommerce/product.blade.php',
        'ecommerce/products.stub' => 'ecommerce/products.blade.php',
    ];

    /**
     * The js files that need to be exported.
     *
     * @var array
     */
    protected $jsfiles = [
        'components/ecommerce/Product.vue' => 'components/ecommerce/Product.vue',
        'components/ecommerce/Admin.vue'   => 'components/ecommerce/Admin.vue',
    ];

    /**
     * The controllers that need to be exported.
     *
     * @var array
     */
    protected $controller = [
        'Ecommerce/BaseController.stub'    => 'Ecommerce/BaseController.php',
        'Ecommerce/BasketController.stub'  => 'Ecommerce/BasketController.php',
        'Ecommerce/ProductController.stub' => 'Ecommerce/ProductController.php',
    ];

    /**
     * Languages supported.
     *
     * @var array
     */
    protected $languages = [
        'da' => 'da/ecommerce.php',
        'en' => 'en/ecommerce.php',
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:ecommerce
                    {--views : Only scaffold the ecommerce views}
                    {--force : Overwrite existing views by default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ecommerce scaffold basic login and registration views and routes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->createDirectories();

        $this->exportViews();

        $this->exportLanguages();

        $this->exportJs();

        if (! $this->option('views')) {
            $this->compileControllers();

            $this->exportRoutes();
        }

        $this->info('Ecommerce installed');
    }

    protected function exportRoutes()
    {
        $routes = file_get_contents(base_path('routes/web.php'));

        if (preg_match('/\/\* Ecommerce \*\//', $routes, $match) && ! $this->option('force')) {
            if (! $this->confirm('The routes already exists. Do you want to replace it?')) {
                return;
            }
        }

        file_put_contents(
            base_path('routes/web.php'),
            file_get_contents(__DIR__.'/stubs/make/routes.stub'),
            FILE_APPEND
        );
    }

    protected function compileControllers()
    {
        foreach ($this->controller as $stub => $value) {
            if (file_exists($controller = app_path('Http/Controllers/'.$value)) && ! $this->option('force')) {
                if (! $this->confirm("The [{$value}] controller already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            $data = str_replace(
                '{{namespace}}',
                $this->getAppNamespace(),
                file_get_contents(__DIR__.'/stubs/make/controllers/'.$stub)
            );

            file_put_contents(
                $controller,
                $data
            );
        }
    }

    /**
     * Create the directories for the files.
     */
    protected function createDirectories()
    {
        if (! is_dir($directory = resource_path('views/layouts'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = resource_path('views/ecommerce'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = resource_path('js/components/ecommerce'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = app_path('Http/Controllers/Ecommerce'))) {
            mkdir($directory, 0755, true);
        }

        foreach ($this->languages as $key => $value) {
            if (! is_dir($directory = resource_path('lang/'.$key))) {
                mkdir($directory, 0755, true);
            }
        }
    }

    /**
     * Export the ecommerce js files.
     */
    protected function exportJs()
    {
        foreach ($this->jsfiles as $key => $value) {
            if (file_exists($view = resource_path('js/'.$value)) && ! $this->option('force')) {
                if (! $this->confirm("The [{$value}] already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            copy(
                __DIR__.'/stubs/make/js/'.$key,
                $view
            );
        }

        // append vuejs modules
        $appConfig = file_get_contents(base_path('resources/js/app.js'));

        if (preg_match('/\/\* Ecommerce \*\//', $appConfig, $match) && ! $this->option('force')) {
            if (! $this->confirm('The vuejs modules already exists in config. Do you want to replace it?')) {
                return;
            }
        }

        $data = str_replace(
            'window.Vue = require(\'vue\');',
            file_get_contents(__DIR__.'/stubs/make/vuejs.stub'),
            $appConfig
        );

        file_put_contents(
            base_path('resources/js/app.js'),
            $data
        );

        $this->info('remember to run: npm run dev');
    }

    /**
     * Export the ecommerce views.
     */
    protected function exportViews()
    {
        foreach ($this->views as $key => $value) {
            if (file_exists($view = resource_path('views/'.$value)) && ! $this->option('force')) {
                if (! $this->confirm("The [{$value}] view already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            copy(
                __DIR__.'/stubs/make/views/'.$key,
                $view
            );
        }
    }

    /**
     * Export the ecommerce languages.
     */
    protected function exportLanguages()
    {
        foreach ($this->languages as $key => $value) {
            if (file_exists($lang = resource_path('lang/'.$value)) && ! $this->option('force')) {
                if (! $this->confirm("The [{$value}] language already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            copy(
                __DIR__.'/stubs/make/lang/'.$value,
                $lang
            );
        }
    }
}
