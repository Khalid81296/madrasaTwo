<?php

namespace App\Providers;

// use Illuminate\Support\ServiceProvider;
use App\Providers\AppServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\Models\Message;

class ViewServiceProvider extends AppServiceProvider
{
        public function boot()
    {
        view()->composer('partials.menu', function ($view)
        {
            //Message Notification --- start
            $NewMessagesCount = Message::select('id')
                ->where('user_receiver', Auth::user()->id)
                ->where('receiver_seen', 0)
                ->where('msg_reqest', 0)
                ->count();
            $msg_request_count = Message::orderby('id', 'DESC')
                // ->select('user_sender', 'user_receiver', 'msg_reqest')
                ->Where('user_receiver', [Auth::user()->id])
                ->Where('msg_reqest', 1)
                ->groupby('user_sender')
                ->count();
            $Ncount = $NewMessagesCount + $msg_request_count;

            $view->with([
                'Ncount' => $Ncount,
                'NewMessagesCount' => $NewMessagesCount,
                'msg_request_count' => $msg_request_count,
            ]);
            //Message Notification  --- End
        });

    }
    public function register()
    {
        //
    }

}
