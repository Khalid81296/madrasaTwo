<?php

namespace App\Http\Controllers\SupportTeam;

use App\Models\Income;
use App\Models\IncomeCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyIncomeRequest;
use App\Http\Requests\StoreIncomeRequest;
use App\Http\Requests\UpdateIncomeRequest;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::all();

        return view('pages.support_team.admin.incomes.index', compact('incomes'));
    }

    public function create()
    {
        $income_categories = IncomeCategory::all()->pluck('name', 'id')->prepend('Please Select', '');

        return view('pages.support_team.admin.incomes.create', compact('income_categories'));
    }

    public function store(StoreIncomeRequest $request)
    {
        $income = Income::create($request->all());
        if($income->id){
            // return $income;
            $catID = $income->income_category_id;
            $catName = DB::table('income_categories')
                    ->where('id', $catID)
                    ->select('name')
                    ->first()->name;
            $mobile = $income->mobile_no;
            $amount = $income->amount;
            $message = $amount . ' টাকা ' .$catName  .' প্রদানের জন্য আল্লাহ তায়ালা আপনাকে অতি উত্তম বিনিময় দান করুক।'."\n".'দারুল ইনসান মাদরাসা';
            // return $message;     
            // $this->send_sms($mobile, $message);
        }
        return redirect()->route('incomes.index');
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

    public function show(Income $income)
    {
        $income->load('income_category', 'created_by');

        return view('pages.support_team.admin.incomes.show', compact('income'));
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

    public function destroy(Income $income)
    {
        $income->delete();

        return back();
    }

    public function massDestroy(MassDestroyIncomeRequest $request)
    {
        Income::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
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
