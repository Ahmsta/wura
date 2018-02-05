<?php

namespace App\Http\Composers;

use Auth;
use Carbon\Carbon;
use Illuminate\View\View;

class LayoutComposer {

    public function hasNotifcations(View $view) {
        $expiredocs = new \App\Models\VehicleDocs();
        $expiredocs = $expiredocs
            ->distinct('vehicleid') 
            ->where('status', 'Expired')
            ->where('expirydate', Carbon::today())
            ->where('ownerid', Auth::id())
            ->count('vehicleid');
        
        if ($expiredocs >= 1) {
            // Return Ringer to show there is a notification 
            $view->with('setColor', 'aqua');
            $view->with('hasNotification', 'fa fa-bell faa-ring animated');
        } else {
            // Return normal bell. There is currently no notification for the user.
            $view->with('setColor', 'white');
            $view->with('hasNotification', 'fa fa-bell-o');
        }
    }

    public function HasCalendarEvents(View $view) {
        $eventscount =  new \App\Models\Calendars();
        $eventscount = $eventscount
            ->distinct('title') 
            ->where('ownerid', Auth::id())
            ->where('start',  Carbon::today()->format('Y-m-d'))
            ->orWhere('end', Carbon::today()->format('Y-m-d'))
            ->whereNull('deleted_at')
            ->count('title');

        if ($eventscount >= 1) {
            // Return Ringer to show there is a notification 
            $view->with('setColor', 'aqua');
            $view->with('hasevent', 'fa fa-calendar faa-pulse animated');
            $view->with('hasNotification', 'fa fa-bell faa-ring animated');
        } else {
            // Return normal bell. There is currently no notification for the user.
            $view->with('setColor', 'white');
            $view->with('hasevent', 'fa fa-calendar');
        }
    }

}