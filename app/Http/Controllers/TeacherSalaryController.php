<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Category;
use App\District;
use App\Models\Notice;
use App\Models\PaymentRecord;
use App\Models\Receipt;
use App\Models\Salary;
use App\Models\SingleReceipt;
use App\Post;
use App\Tag;
use App\Upazila;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class TeacherSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $data['users'] = User::with('salaries')->whereIn('user_type', ['teacher','principal','cook','accountant'])->paginate(20);


        // PaymentRecord::orderBy('id', 'desc')->paginate(20);
        // $client =  new Client();
        // return $response = $client->get('https://corona.lmao.ninja/v2/all');
        // $data['Receipt'] = Receipt::orderBy('id', 'DESC')->paginate(20);
        // $data['SingleReceipt'] = SingleReceipt::orderBy('id', 'DESC')->paginate(20);
        $data['page_title'] = 'Staff Salary List';
        // // return $data;

        return view('pages.support_team.expenses.salary_records')->with($data);

        // $users = User::where('user_type', 'teacher')->get();
        // foreach( $users as  $user){
        //     $salary = new Salary();
        //     $salary->user_id = $user->id;
        //     $salary->amount = 1000;
        //     $salary->designation = $user->user_type;
        //     $salary->created_at = Carbon::now();
        //     $salary->created_by = Auth::user()->id;
        //     $salary->save();

        // }
        // return 'success';



    }
    public function updateSalary(Request $request){
        $salary =  Salary::where('user_id', $request->user_id)->first();
        if($salary == null){
            $salary = new Salary();
        }
        $salary->user_id = $request->user_id;
        $salary->amount =  $request->amount;
        $salary->designation = $request->designation;
        $salary->updated_at = Carbon::now();
        $salary->created_by = Auth::user()->id;
        if($salary->save()){
            return Response()->json(["success" => 'Successfully updated!', "data" => [] ]);
        }
        return Response()->json(["error" => 'Something went wrong', "data" => [] ]);
    }

}
