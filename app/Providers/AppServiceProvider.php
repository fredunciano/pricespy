<?php

namespace App\Providers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Blade::directive('t', function ($expression) {
            return "<?php echo t($expression); ?>";
        });
        Blade::directive('tl', function ($expression) {
            return "<?php echo t($expression, false); ?>";
        });
        Blade::directive('tbl', function ($expression) {
            return "<?php echo {$this->emphasiseLastWord($expression)}; ?>";
        });

        //Appending Query string to pagination

        $this->app->resolving(LengthAwarePaginator::class, function ($paginator) {
            return $paginator->appends(array_except(Input::query(), $paginator->getPageName()));
        });
    }

    /**
     * Wrap the last word into <span> tags in order to
     *
     * @param $expression
     * @return string
     */

    private function emphasiseLastWord($expression)
    {
        $translation = t(str_replace("'", '', $expression));
        $words = explode(' ', $translation);
        if (count($words) > 1) {
            end($words);
            $string = $words[0] . '<br /><span class="secondary">' . implode(' ', array_slice($words, 1)) . '</span>';
        } else {
            $string = '<span class="secondary">' . $words[0] . '</span>';
        }
        return "'" . $string . "'";
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
