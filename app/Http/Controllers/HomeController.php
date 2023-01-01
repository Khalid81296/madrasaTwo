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
        $d=[];
        if(Qs::userIsTeamSAT()){
            // $d['users'] = $this->user->getAll();
        
            $d['total_student'] = DB::table('users')
                ->join('student_records', 'users.id', '=', 'student_records.user_id')
                ->where('users.user_type','student')
                ->where('student_records.grad',0)
                ->count();
        
            $d['total_male_student'] = DB::table('users')
                ->join('student_records', 'users.id', '=', 'student_records.user_id')
                ->where('users.user_type','student')
                ->where('users.gender','Male')
                ->where('student_records.grad',0)
                ->count();
        
            $d['total_female_student'] = DB::table('users')
                ->join('student_records', 'users.id', '=', 'student_records.user_id')
                ->where('users.user_type','student')
                ->where('users.gender','Female')
                ->where('student_records.grad',0)
                ->count();
        
            $d['total_badrin'] = DB::table('users')
                ->where('users.user_type','badrin')
                ->count();
        
            $d['total_teacher'] = DB::table('users')
                ->where('users.user_type','teacher')
                ->count();
        
            $d['total_admin'] = DB::table('users')
                ->where('users.user_type','admin')
                ->count();
        
            $d['total_parents'] = DB::table('users')
                ->where('users.user_type','parent')
                ->count();

        }
        // return $d;

        return view('pages.support_team.dashboard', $d);
    }
}
