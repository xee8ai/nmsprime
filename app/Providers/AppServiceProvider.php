<?php

namespace App\Providers;

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
        // use old laravel 4.2 blade tag syntax, NOTE: delete all cached files under storage/views/ when we change this
        \Blade::setRawTags('{{', '}}');
        // \Blade::setContentTags('{{{', '}}}');
        // \Blade::setEscapedContentTags('{{{', '}}}');

        \Blade::directive('DivOpen', function ($expression) {
            return "<?php echo Form::openDivClass($expression); ?>";
        });

        \Blade::directive('DivClose', function () {
            return '<?php echo Form::closeDivClass(); ?>';
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Facade to Object binding
        $this->app->bind('chanellog', 'Acme\log\ChannelWriter');
    }
}
