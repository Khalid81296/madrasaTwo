<?php

namespace App\Http\Controllers;

use App\Helpers\Qs;
use App\Repositories\UserRepo;

class HomeController extends Controller
{
    protected $user;
    public function __construct(UserRepo $user)
    {
        $this->user = $user;
    }


    public function index()
    {
        return redirect()->route('dashboard');
    }

    public function privacy_policy()
    {
        $data['app_name'] = config('app.name');
        $data['app_url'] = config('app.url');
        $data['contact_phone'] = Qs::getSetting('phone');
        return view('pages.other.privacy_policy', $data);
    }

    public function terms_of_use()
    {
        $data['app_name'] = config('app.name');
        $data['app_url'] = config('app.url');
        $data['contact_phone'] = Qs::getSetting('phone');
        return view('pages.other.terms_of_use', $data);
    }

    public function dashboard()
    {
        // return 'mk';
        // UserID: darulinsan
        // Passwrd: FTXCZW4N
        // $text = 'জারীকারক, রিকুইজিশন দাখিলকারী/আবেদনকারীদের প্রোফাইলে মোবাইল নাম্বার ম্যান্ডাটরি ফিল্ড হিসাবে থাকবে, ই-মেইল অপশনাল ফিল্ড হিসাবে থাকবে। ঋণ গ্রহিতার রিভিউয়ের স্থলে ঋন গ্রহিতার আপিল হবে।';
        // $smsresult = file_get_contents("http://66.45.237.70/api.php?username=darulinsan&password=FTXCZW4N&number=8801689322376&message=$text");
        // return $smsresult;
        $d=[];
        if(Qs::userIsTeamSAT()){
            $d['users'] = $this->user->getAll();
        }
        // return $d;
        return view('pages.support_team.dashboard', $d);
    }
}
