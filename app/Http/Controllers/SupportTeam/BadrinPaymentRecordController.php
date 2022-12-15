<?php

namespace App\Http\Controllers\SupportTeam;

use App\Models\BadrinPaymentRecord;
use App\Models\IncomeCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Badrin\BadrinRecordCreate;
use App\Http\Requests\Badrin\BadrinPaymentRecordCreate;
use App\Http\Requests\Badrin\BadrinRecordUpdate;
use App\Http\Requests\Badrin\BadrinPaymentRecordUpdate;

class BadrinPaymentRecordController extends Controller
{
    public function index()
    {
        $payments = BadrinPaymentRecord::all();
        // return $payments;
        foreach ($payments as $key => $value) {
            if($value->month_id == 1){
                $payments[$key]->month_name = 'January';
            }elseif($value->month_id == 2){
                $payments[$key]->month_name = 'February';
            }elseif($value->month_id == 3){
                $payments[$key]->month_name = 'March';
            }elseif($value->month_id == 4){
                $payments[$key]->month_name = 'April';
            }elseif($value->month_id == 5){
                $payments[$key]->month_name = 'May';
            }elseif($value->month_id == 6){
                $payments[$key]->month_name = 'June';
            }elseif($value->month_id == 7){
                $payments[$key]->month_name = 'July';
            }elseif($value->month_id == 8){
                $payments[$key]->month_name = 'August';
            }elseif($value->month_id == 9){
                $payments[$key]->month_name = 'September';
            }elseif($value->month_id == 10){
                $payments[$key]->month_name = 'October';
            }elseif($value->month_id == 11){
                $payments[$key]->month_name = 'November';
            }elseif($value->month_id == 12){
                $payments[$key]->month_name = 'December';
            }
        }

        return view('pages.support_team.badrins.payment.index', compact('payments'));
    }

    
    public function create()
    {
        
        $data['badrins'] = DB::table('users')->where('user_type', 'badrin')->get();
        return view('pages.support_team.badrins.payment.add', $data);
    }

    public function store(BadrinPaymentRecordCreate $req)
    {
        
        // return $req;
       $payment = BadrinPaymentRecord::create($req->all());
        if($payment->id){
            // return $payment;\
            $mobile = DB::table('users')
                    ->where('user_type', 'badrin')
                    ->where('id', $payment->badrin_id)
                    ->select('phone')
                    ->first()->phone;
            $mobile = $payment->mobile_no;
            $amount = $payment->amt_paid;
            $message = $amount . ' টাকা মাসিক চাঁদা প্রদানের জন্য আল্লাহ তায়ালা আপনাকে অতি উত্তম বিনিময় দান করুক।'."\n".'দারুল ইনসান মাদরাসা';
            // return $message;     
            $this->send_sms($mobile, $message);
        }
        return redirect()->route('badrinPayment.index');
    }

    public function edit(Income $income)
    {
        // return $income;
        $income_categories = IncomeCategory::all()->pluck('name', 'id')->prepend('Please Select', '');

        $income->load('income_category', 'created_by');

        return view('pages.support_team.admin.incomes.edit', compact('income_categories', 'income'));
    }

    public function update(UpdateIncomeRequest $request, Income $income)
    {
        $income->update($request->all());

        return redirect()->route('incomes.index');
    }

    public function show($id)
    {
        $payment = BadrinPaymentRecord::where('id',$id)->first();
        // dd($payment);
        return view('pages.support_team.badrins.payment.show', compact('payment'));
    }

    public function printList($id)
    {
        $income = DB::table('incomes')
        ->join('income_categories', 'incomes.income_category_id', '=', 'income_categories.id')
        ->select('incomes.*','income_categories.name')
        ->where('incomes.id', '=', $id)
        ->first();

        // dd($income);
        return view('pages.support_team.admin.incomes.print', compact('income'));
    }

    public function destroy($id='')
    {
        DB::table('badrin_payment_records')->where('id', $id)->delete();
        return redirect()->route('badrinPayment.index')
            ->with('success', 'ইউজার ডাটা সফলভাবে মুছে ফেলা হয়েছে');
    }

    public function getDependentBadrin($id=null)
    {
        $id = $_GET['id'];
        $year = date('Y');
        $badrinPaymentId = DB::table('badrin_payment_records')->where('month_id',$id)->select("badrin_id")->get();
        if(!empty($badrinPaymentId)){
            foreach ($badrinPaymentId as $key => $value) {
                $badrins = DB::table('users')->where('user_type', 'badrin')->where('id', '!=', $value->badrin_id)->pluck("name","id");
            }
        }else{
             $badrins = DB::table('users')->where('user_type', 'badrin')->pluck("name","id");
        }

        return json_encode($badrins);
    }
    public function getDependentDistrict($id)
    {
        $subcategories = DB::table("district")->where("division_id",$id)->pluck("district_name_bn","id");
        return json_encode($subcategories);
    }

    public function send_sms($mobile, $message){
            
            // return $message;
            $url = "http://66.45.237.70/api.php";
            
            $data= array(
            'username'=>"darulinsan",
            'password'=>"FTXCZW4N",
            'number'=>$mobile,
            'message'=>$message
            );

            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $smsresult = curl_exec($ch);
            $p = explode("|",$smsresult);
            $sendstatus = $p[0];

            return $smsresult; 



      }
}
