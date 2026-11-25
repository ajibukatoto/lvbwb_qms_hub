<?php

namespace App\Providers;

use App\Models\AuditTrail;
use App\Observers\AuditTrailObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use ReflectionClass;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $observer = new AuditTrailObserver();

        foreach (File::files(app_path('Models')) as $file) {
            $class = 'App\\Models\\' . $file->getFilenameWithoutExtension();

            if (!class_exists($class)) {
                continue;
            }

            $reflection = new ReflectionClass($class);

            if (
                $reflection->isAbstract() ||
                !$reflection->isSubclassOf(Model::class) ||
                $class === AuditTrail::class
            ) {
                continue;
            }

            $class::observe($observer);
        }
    }
}