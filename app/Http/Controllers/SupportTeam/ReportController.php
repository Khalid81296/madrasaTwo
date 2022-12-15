<?php

namespace App\Http\Controllers\SupportTeam;

use App\Helpers\Qs;
use App\Helpers\Pay;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PaymentCreate;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Payment\PaymentUpdate;
use App\Repositories\SettingRepo;
use App\Models\Setting;
use App\Models\Payment;
use App\Models\PaymentRecord;
use App\Repositories\MyClassRepo;
use App\Repositories\PaymentRepo;
use App\Repositories\StudentRepo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;

class ReportController extends Controller
{
    protected $my_class, $pay, $student, $year;

    public function __construct(SettingRepo $setting, MyClassRepo $my_class, PaymentRepo $pay, StudentRepo $student)
    {
        $this->setting = $setting;
        $this->my_class = $my_class;
        $this->pay = $pay;
        $this->year = Qs::getCurrentSession();
        $this->student = $student;

        $this->middleware('teamAccount');
    }

    public function payment()
    {
        $s = $this->setting->all();
        $d['my_classes'] = $this->my_class->all();
        $d['selected'] = false;
        $d['page_title'] = 'Payment Report';
        $d['s'] = $s->flatMap(function($s){
            return [$s->type => $s->description];
        });
        $d['years'] = $this->pay->getPaymentYears();
        // return $d;
        return view('pages.support_team.report.index', $d);
    }

    public function badrinPayment()
    {
        $s = $this->setting->all();
        // $d['my_classes'] = $this->my_class->all();
        $d['badrins'] = DB::table('users')->where('user_type', 'badrin')->select('name','id')->get();

        $d['selected'] = false;
        $d['page_title'] = 'Payment Report';
        $d['s'] = $s->flatMap(function($s){
            return [$s->type => $s->description];
        });
        $d['years'] = $this->pay->getPaymentYears();
        // return $d;
        return view('pages.support_team.report.badrinPayment', $d);
    }

    

    public function monthlyIncExp()
    {
        $s = $this->setting->all();
        // $d['my_classes'] = $this->my_class->all();
        $d['selected'] = false;
        $d['page_title'] = 'Monthly Income Expence Report';
        $d['s'] = $s->flatMap(function($s){
            return [$s->type => $s->description];
        });
        $d['years'] = date('Y', strtotime(now()));

        return view('pages.support_team.report.monthlyIncExp', $d);
    }

    public function show($year)
    {
        $d['payments'] = $p = $this->pay->getPayment(['year' => $year])->get();

        if(($p->count() < 1)){
            return Qs::goWithDanger('payments.index');
        }

        $d['selected'] = true;
        $d['my_classes'] = $this->my_class->all();
        $d['years'] = $this->pay->getPaymentYears();
        $d['year'] = $year;

        return view('pages.support_team.payments.index', $d);

    }
    public function pdf_generate(Request $request)
    {
        // return $request->all();
      // dd($request->all());
      // Case List Report
        if($request->btnsubmit == 'pdf_num_payment_paid'){

            $request->validate(
              ['my_classes' => 'required', 'month' => 'required'],
              ['my_classes.required' => 'শ্রেণী নির্বাচন করুন', 'month.required' => 'মাস নির্বাচন করুন']
            );    

            $data['page_title'] = 'ক্লাস ভিত্তিক শিক্ষার্থী তালিকা যারা টিউশন ফি পরিশোধ করেছে'; //exit;

            $payment_id = DB::table('payments')->select('id')->where('my_class_id',$request->my_classes)->where('year',$request->current_session)->where('month_id',$request->month)->first();

            if ($payment_id != null) {
                    $data['payment_status'] = DB::table('payment_records')
                                    ->join('student_records', 'payment_records.student_id', '=', 'student_records.id')
                                    ->join('users', 'payment_records.student_id', '=', 'users.id')
                                    ->join('payments', 'payment_records.payment_id', '=', 'payments.id')
                                    ->where('payment_id',$payment_id->id)
                                    ->where('is_paid',1)
                                    ->select('payments.amount','payment_records.student_id','payment_records.amt_paid','payment_records.balance', 'users.name', 'users.photo', 'users.phone')
                                    ->get();
            }else{
                return redirect(route('report.index'))->with('pop_error', __('msg.rnf'));
            }



            $data['year'] = $request->current_session;
            $data['month'] = $request->month;

            return view('pages.support_team.report.list', $data);
        }

        if($request->btnsubmit == 'pdf_num_payment_unpaid'){
            
            $request->validate(
              ['my_classes' => 'required', 'month' => 'required'],
              ['my_classes.required' => 'শ্রেণী নির্বাচন করুন', 'month.required' => 'মাস নির্বাচন করুন']
            ); 

            $data['page_title'] = 'ক্লাস ভিত্তিক শিক্ষার্থী তালিকা যারা টিউশন ফি পরিশোধ করেনি'; //exit;

            $payment_id = DB::table('payments')->select('id')->where('my_class_id',$request->my_classes)->where('year',$request->current_session)->where('month_id',$request->month)->first();

            if ($payment_id != null) {
                $data['payment_status'] = DB::table('payment_records')
                                    ->join('student_records', 'payment_records.student_id', '=', 'student_records.id')
                                    ->join('users', 'student_records.user_id', '=', 'users.id')
                                    ->join('payments', 'payment_records.payment_id', '=', 'payments.id')
                                    ->where('payment_id',$payment_id->id)
                                    ->where('is_paid',0)
                                    ->select('payments.amount','payment_records.student_id','payment_records.amt_paid','payment_records.balance', 'users.name', 'users.photo', 'users.phone')
                                    ->get();
            }else{
                return redirect(route('report.index'))->with('pop_error', __('msg.rnf'));
            }



            $data['year'] = $request->current_session;
            $data['month'] = $request->month;

            // return $data;

            return view('pages.support_team.report.list', $data);
           
        }


       
    }
    public function badrin_pdf_generate(Request $request)
    {
        // return $request->all();
      // dd($request->all());
      // Case List Report
        if($request->btnsubmit == 'pdf_num_payment_paid'){

            $request->validate(
              ['my_classes' => 'required', 'month' => 'required'],
              ['my_classes.required' => 'শ্রেণী নির্বাচন করুন', 'month.required' => 'মাস নির্বাচন করুন']
            );    

            $data['page_title'] = 'ক্লাস ভিত্তিক শিক্ষার্থী তালিকা যারা টিউশন ফি পরিশোধ করেছে'; //exit;

            $payment_id = DB::table('payments')->select('id')->where('my_class_id',$request->my_classes)->where('year',$request->current_session)->where('month_id',$request->month)->first();

            if ($payment_id != null) {
                    $data['payment_status'] = DB::table('payment_records')
                                    ->join('student_records', 'payment_records.student_id', '=', 'student_records.id')
                                    ->join('users', 'payment_records.student_id', '=', 'users.id')
                                    ->join('payments', 'payment_records.payment_id', '=', 'payments.id')
                                    ->where('payment_id',$payment_id->id)
                                    ->where('is_paid',1)
                                    ->select('payments.amount','payment_records.student_id','payment_records.amt_paid','payment_records.balance', 'users.name', 'users.photo', 'users.phone')
                                    ->get();
            }else{
                return redirect(route('report.index'))->with('pop_error', __('msg.rnf'));
            }



            $data['year'] = $request->current_session;
            $data['month'] = $request->month;

            return view('pages.support_team.report.list', $data);
        }

        if($request->btnsubmit == 'pdf_num_payment_unpaid'){
            
            $request->validate(
              ['my_classes' => 'required', 'month' => 'required'],
              ['my_classes.required' => 'শ্রেণী নির্বাচন করুন', 'month.required' => 'মাস নির্বাচন করুন']
            ); 

            $data['page_title'] = 'ক্লাস ভিত্তিক শিক্ষার্থী তালিকা যারা টিউশন ফি পরিশোধ করেনি'; //exit;

            $payment_id = DB::table('payments')->select('id')->where('my_class_id',$request->my_classes)->where('year',$request->current_session)->where('month_id',$request->month)->first();

            if ($payment_id != null) {
                $data['payment_status'] = DB::table('payment_records')
                                    ->join('student_records', 'payment_records.student_id', '=', 'student_records.id')
                                    ->join('users', 'student_records.user_id', '=', 'users.id')
                                    ->join('payments', 'payment_records.payment_id', '=', 'payments.id')
                                    ->where('payment_id',$payment_id->id)
                                    ->where('is_paid',0)
                                    ->select('payments.amount','payment_records.student_id','payment_records.amt_paid','payment_records.balance', 'users.name', 'users.photo', 'users.phone')
                                    ->get();
            }else{
                return redirect(route('report.index'))->with('pop_error', __('msg.rnf'));
            }



            $data['year'] = $request->current_session;
            $data['month'] = $request->month;

            // return $data;

            return view('pages.support_team.report.list', $data);
           
        }


       
    }

    public function expenceIncomeReport(Request $request)
    {
        if($request->btnsubmit == 'pdf_num_expence'){

            $request->validate(
              [ 'month' => 'required'],
              ['month.required' => 'মাস নির্বাচন করুন']
            );    

            

            $data['page_title'] = 'মাদরাসার মাসিক ব্যয়ের হিসাবের তালিকা '; //exit;

            $data['expenses'] = DB::table('expenses')
                                ->select('expenses.*','expense_categories.name')
                                ->join('expense_categories','expenses.expense_category_id','=','expense_categories.id')
                                ->where('expenses.entry_month_id',$request->month)
                                ->whereYear('expenses.entry_date', '=', $request->current_session)
                                ->get();

            $data['year'] = $request->current_session;
            $data['month'] = $request->month;

        // return $data;
            return view('pages.support_team.report.expence', $data);
        }

        if($request->btnsubmit == 'pdf_num_income'){
            
            $request->validate(
              [ 'month' => 'required'],
              [ 'month.required' => 'মাস নির্বাচন করুন']
            ); 

            $data['page_title'] = 'মাদরাসার মাসিক আয়ের হিসাবের তালিকা'; //exit;
           
            $totalAmount = 0;
            $payment_ids = DB::table('payments')->select('id')->whereYear('created_at', '=', $request->current_session)->where('month_id',$request->month)->get();
            foreach($payment_ids as $payment){
                $paymentAmount = PaymentRecord::select(DB::raw('SUM(amt_paid) as total_amount'))
                            ->where('payment_id',$payment->id)
                            ->where('is_paid',1)
                            ->get();
                $totalAmount += $paymentAmount[0]->total_amount;
            }
            
            $data['incomes'] = DB::table('incomes')
                                ->select('incomes.*','income_categories.name')
                                ->join('income_categories','incomes.income_category_id','=','income_categories.id')
                                ->where('incomes.entry_month_id',$request->month)
                                ->whereYear('incomes.entry_date', '=', $request->current_session)
                                ->get();


            $data['payments'] = $totalAmount;
            $data['year'] = $request->current_session;
            $data['month'] = $request->month;

            // return $data;

            return view('pages.support_team.report.income', $data);
                
           
        }

        //=========================== Date Between==========================//

        if($request->btnsubmit == 'pdf_num_dateBetween_expence'){

            $request->validate(
              [ 'date_start' => 'required','date_end' => 'required'],
              ['date_start' => 'শুরুর তারিখ নির্বাচন করুন','date_end' => 'শেষের তারিখ নির্বাচন করুন']
            );    

             // Convert DB date formate
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_start)));
            $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
            

            $data['page_title'] = 'মাদরাসার ব্যয়ের হিসাবের তালিকা '; //exit;

            $data['expenses'] = DB::table('expenses')
                                ->select('expenses.*','expense_categories.name')
                                ->join('expense_categories','expenses.expense_category_id','=','expense_categories.id')
                                ->whereBetween('expenses.entry_date', [$dateFrom, $dateTo])
                                ->get();
            $data['dateFrom'] = $dateFrom; 
            $data['dateTo'] = $dateTo;
            $data['year'] = $request->current_session;
            $data['month'] = $request->month;

        // return $data;
            return view('pages.support_team.report.othersExpence', $data);
        }

        if($request->btnsubmit == 'pdf_num_dateBetween_income'){
            
            $request->validate(
              [ 'date_start' => 'required','date_end' => 'required'],
              [ 'date_start' => 'শুরুর তারিখ নির্বাচন করুন','date_end' => 'শেষের তারিখ নির্বাচন করুন']
            ); 

            $data['page_title'] = 'মাদরাসার অন্যান্য আয়ের হিসাবের তালিকা'; //exit;
           
            // Convert DB date formate
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_start)));
            $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
            
            $data['incomes'] = DB::table('incomes')
                                ->select('incomes.*','income_categories.name')
                                ->join('income_categories','incomes.income_category_id','=','income_categories.id')
                                ->whereBetween('incomes.entry_date', [$dateFrom, $dateTo])
                                ->get();


            $data['dateFrom'] = $dateFrom; 
            $data['dateTo'] = $dateTo;
            $data['year'] = $request->current_session;
            $data['month'] = $request->month;

            // return $data;

            return view('pages.support_team.report.othersIncome', $data);
                
           
        }

        //=========================== Yearly ==========================//

        if($request->btnsubmit == 'pdf_num_yearly_expence'){

            $request->validate(
              [ 'current_session' => 'required'],
              ['current_session' => 'বছর নির্বাচন করুন']
            );            

            $data['page_title'] = 'মাদরাসার বাৎসরিক ব্যয়ের হিসাবের তালিকা '; //exit;

            $data['expenses'] = DB::table('expenses')
                                ->select('expenses.*',DB::raw('sum(expenses.amount) as totalAmount'),'expense_categories.name')
                                ->join('expense_categories','expenses.expense_category_id','=','expense_categories.id')
                                ->where('expenses.entry_year', $request->current_session)
                                ->groupBy('expenses.expense_category_id')
                                ->get();
            $data['year'] = $request->current_session;
            $data['month'] = $request->month;

        // return $data;
            return view('pages.support_team.report.othersExpenceYearly', $data);
        }

        if($request->btnsubmit == 'pdf_num_yearly_income'){
            
            $request->validate(
              [ 'current_session' => 'required'],
              [ 'current_session' => 'বছর নির্বাচন করুন']
            ); 

            $data['page_title'] = 'মাদরাসার অন্যান্য আয়ের হিসাবের তালিকা'; //exit;
           
            // Convert DB date formate
            
            $data['incomes'] = DB::table('incomes')
                                ->select('incomes.*',DB::raw('sum(incomes.amount) as totalAmount'),'income_categories.name')
                                ->join('income_categories','incomes.income_category_id','=','income_categories.id')
                                ->where('incomes.entry_year', $request->current_session)
                                ->groupBy('incomes.income_category_id')
                                // ->whereBetween('incomes.entry_date', [$dateFrom, $dateTo])
                                ->get();
            $data['year'] = $request->current_session;
            $data['month'] = $request->month;

            // return $data;

            return view('pages.support_team.report.othersIncomeYearly', $data);
                
           
        }



        if($request->btnsubmit == 'pdf_num_profit'){
            
            $request->validate(
              [ 'current_session' => 'required'],
              [ 'current_session.required' => 'মাস নির্বাচন করুন']
            ); 

            $data['page_title'] = 'মাদরাসার বাৎসরিক আয়ের হিসাবের তালিকা'; //exit;
           
            $totalAmount = 0;
            $payment_ids = DB::table('payments')->select('id')->whereYear('created_at', '=', $request->current_session)->get();
            foreach($payment_ids as $payment){
                $paymentAmount = PaymentRecord::select(DB::raw('SUM(amt_paid) as total_amount'))
                            ->where('payment_id',$payment->id)
                            ->where('is_paid',1)
                            ->get();
                $totalAmount += $paymentAmount[0]->total_amount;
            }
            
            $data['incomes'] = DB::table('incomes')
                                ->select('incomes.*',DB::raw('sum(incomes.amount) as totalAmount'),'income_categories.name')
                                ->join('income_categories','incomes.income_category_id','=','income_categories.id')
                                ->where('incomes.entry_year', $request->current_session)
                                ->groupBy('incomes.income_category_id')
                                // ->whereBetween('incomes.entry_date', [$dateFrom, $dateTo])
                                ->get();
            $data['expenses'] = DB::table('expenses')
                                ->select('expenses.*',DB::raw('sum(expenses.amount) as totalAmount'),'expense_categories.name')
                                ->join('expense_categories','expenses.expense_category_id','=','expense_categories.id')
                                ->where('expenses.entry_year', $request->current_session)
                                ->groupBy('expenses.expense_category_id')
                                ->get();

            $data['payments'] = $totalAmount;
            $data['year'] = $request->current_session;
            $data['month'] = $request->month;

            // return $data;

            return view('pages.support_team.report.profit', $data);
                
           
        }
    }

}
