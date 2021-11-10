<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        Blade::directive('form', function () {
            $form = "<script src=\"".asset('js/Modules/System/pages/ajax_form.js')."\"></script>";
            return '<x-include.form.ajax />';
        });



        // Add @var for Variable Assignment
        Blade::directive('var', function ($expression) {

            // Strip Open and Close Parenthesis
            $expression = substr(substr($expression, 0, -1), 1);

            list($variable, $value) = explode('\',', $expression, 2);

            // Ensure variable has no spaces or apostrophes
            $variable = trim(str_replace('\'', '', $variable));

            // Make sure that the variable starts with $
            if (!str_starts_with($variable, '$')) {
                $variable = '$' . $variable;
            }

            $value = trim($value);
            return "<?php {$variable} = {$value}; ?>";
        });
        
    }
}
