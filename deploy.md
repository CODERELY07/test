# Deploying Laravel to Vercel (No Database)

This guide outlines the exact file configurations and Vercel dashboard settings required to deploy a database-less Laravel application seamlessly using a serverless PHP runtime.

---

## 1. Required Configuration Files

### `.vercelignore`
Prevents local development files, dependencies, and sensitive environment data from being uploaded to Vercel during deployment.

* `/node_modules`
* `/vendor`
* `/storage/*.key`
* `.env`
* `.env.*`

```bash
    /vendor
```
### `vercel.json`
Configures the Vercel deployment pipeline, binds the serverless PHP community runtime, and routes all public traffic directly to your application entry point.

* **Runtime Configured:** `vercel-php@0.7.5` (or latest stable release)
* **Asset Routing:** Maps static asset requests to `/public/build`
* **Fallback Routing:** Routes all other endpoints directly through the `api/index.php` serverless bridge.

---
```bash
    {
    "version": 2,
      "framework": null,
    "functions": {
        "api/index.php": { "runtime": "vercel-php@0.7.1" }
    },
     "routes": [
        {
            "src": "/build/(.*)",
            "dest": "/public/build/$1"
        },
        {
            "src": "/(css|js|images|fonts)/(.*)",
            "dest": "/public/$1/$2"
        },
        {
            "src": "/favicon.ico",
            "dest": "/public/favicon.ico"
        },
        {
            "src": "/robots.txt",
            "dest": "/public/robots.txt"
        },
        {
            "src": "/(.*)",
            "dest": "/api/index.php"
        }
    ],
     "headers": [
    {
      "source": "/(.*)",
      "headers": [
        { "key": "Access-Control-Allow-Credentials", "value": "true" },
        { "key": "Access-Control-Allow-Origin", "value": "*" },
        { "key": "Access-Control-Allow-Methods", "value": "GET,OPTIONS,PATCH,DELETE,POST,PUT" },
        { "key": "Access-Control-Allow-Headers", "value": "X-CSRF-Token, X-Requested-With, Accept, Accept-Version, Content-Length, Content-MD5, Content-Type, Date, X-Api-Version" }
      ]
    }
  ],
    "env": {
        "APP_ENV": "production",
        "APP_DEBUG": "false",    
        "APP_URL": "https://your-site.vercel.app",
 
        "APP_CONFIG_CACHE": "/tmp/config.php",
        "APP_EVENTS_CACHE": "/tmp/events.php",
        "APP_PACKAGES_CACHE": "/tmp/packages.php",
        "APP_ROUTES_CACHE": "/tmp/routes.php",
        "APP_SERVICES_CACHE": "/tmp/services.php",
        "VIEW_COMPILED_PATH": "/tmp",
 
        "CACHE_DRIVER": "array",
        "LOG_CHANNEL": "stderr",
        "SESSION_DRIVER": "cookie"
    }
}
```

## 2. Core Code Architectures to Modify

### `api/index.php`
Create an `api` directory in your root folder. This file serves as the core entry point for Vercel, securely forwarding incoming requests to Laravel's native `/public/index.php`.

```bash
    <?php
    require __DIR__ . "/../public/index.php";
```

### `app/Providers/AppServiceProvider.php`
Because Vercel operates on a **read-only** filesystem, you must update the `boot()` method to dynamically rebind the application's storage path to the serverless `/tmp/storage` directory when running in a production environment.

```bash
<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
   public function boot(): void
    {
        if (config('app.env') === 'production' || app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}

```
### `bootstrap/app.php`
Inject initialization logic within this bootstrap file to check if the environment is production. If true, it must programmatically create the required dynamic directory trees inside Vercel's volatile `/tmp` space:
* `/tmp/storage/framework/views`
* `/tmp/storage/framework/cache`
* `/tmp/storage/framework/sessions`
* `/tmp/storage/app/public`

```bash
    <?php

    use Illuminate\Foundation\Application;
    use Illuminate\Foundation\Configuration\Exceptions;
    use Illuminate\Foundation\Configuration\Middleware;

    return Application::configure(basePath: dirname(__DIR__))
        ->withRouting(
            web: __DIR__.'/../routes/web.php',
            commands: __DIR__.'/../routes/console.php',
            health: '/up',
        )
        ->withMiddleware(function (Middleware $middleware): void {
            $middleware->trustProxies(at: '*');
        })
        ->withExceptions(function (Exceptions $exceptions): void {
            //
        })->create();

```
---

## 3. Build Commands & Asset Handling

Execute these preparation steps inside your development environment to set up CORS configuration and asset distribution boundaries:

```bash
# Create the distribution directory if explicitly required by frontend pipelines
mkdir -p dist

# Publish the CORS configuration system files
php artisan config:publish cors

```bash
    <?php

return [

    /*

    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------

    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute

    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://mozilla.org
    |
    */

    // OPEN FOR TESTING: Allows all paths, methods, and origins
    'paths' => ['*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [env('APP_URL')],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
```

## 4. Vercel Dashboard Configurations

### Environment Variables (`Settings -> Environment Variables`)

Ensure these precise keys are bound to your active Vercel environment:

| Key | Suggested Value | Purpose / Notes |
| :--- | :--- | :--- |
| **`APP_URL`** | `https://your-project.vercel.app` | Your explicit live domain path |
| **`APP_DEBUG`** | `true` |for testing but after done debug make it `false` |
| **`APP_KEY`** | `base64:...` | Application encryption string |


### Build & Deployment Overrides (`Settings -> Build & Development`)

Toggle the **Override** switch for the following two fields:

* **Build Command:** `npm run build` *(or `vite build` depending on your build orchestrator)*
* **Output Directory:** `public`


# Supabase & Vercel Deployment Setup

### 1. Get Supabase Connection String
1. Go to your **Supabase Dashboard** and click **Connect** (top right).
2. Choose the **Direct Connection** method.
3. Set the Connection Pooler type to **Session Pooler** and mode to **URI**.
4. Copy the provided connection string.
   * *Note: If you forgot your password, reset it under **Project Settings > Database > Reset password**.*

### 2. Configure Vercel Environment Variables
Add the following keys to your Vercel Project Environment Variables. 
*(Replace placeholders with your copied Supabase details)*

```env
DB_CONNECTION=pgsql
DB_URL=your_copied_supabase_uri_with_password
DB_SCHEMA=laravel
SESSION_DRIVER=database
APP_KEY=base64:your_generated_laravel_app_key_here
```


