<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Models\ContactMessage;


class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $siteLogo = DB::table('site_settings')
        ->where('key', 'site_logo')
        ->value('value');

        view()->share('siteLogo', $siteLogo);

        View::composer('layouts.admin', function ($view) {
            if (auth()->check() && auth()->user()->role === 'admin') {
                $unreadMessagesCount = ContactMessage::unread()->count();
                $view->with('unreadMessagesCount', $unreadMessagesCount);
            }
        });
    }
}
