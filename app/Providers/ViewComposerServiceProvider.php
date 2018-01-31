<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->HasNotifications();
        $this->HasCalendarEvents();
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

    /**
     * Check if the user has any outstanding Notification. 
    */
    private function HasNotifications() 
    {
        View::composer('layouts.wura',  '\App\Http\Composers\LayoutComposer@hasNotifcations');
    }

    /**
     * Check if the user has any outstanding Calendar Events for the day. 
    */
    private function HasCalendarEvents() 
    {
        View::composer('layouts.wura',  '\App\Http\Composers\LayoutComposer@HasCalendarEvents');
    }
}
