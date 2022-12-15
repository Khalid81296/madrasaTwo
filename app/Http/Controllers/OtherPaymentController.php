<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Category;
use App\District;
use App\Models\Notice;
use App\Models\OtherPayment;
use App\Models\PaymentRecord;
use App\Models\PaymentType;
use App\Models\Receipt;
use App\Models\SingleReceipt;
use App\Post;
use App\Tag;
use App\Upazila;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class OtherPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $data['other_payments'] = OtherPayment::orderBy('id', 'DESC')->paginate(20);
        $data['page_title'] = 'Other Payment List';
        // return $data;

        return view('pages.support_team.payments.other_payment.index')->with($data);
    }
    public function create()
    {
        $data['payment_types'] = PaymentType::all();
        $data['page_title'] = 'Other Payment';
        return view('pages.support_team.payments.other_payment.create')->with($data);
    }
    public function store(Request $request)
    {
        // return $request;
        // $pay = new OtherPayment();
        $data = [
            'name' => $request->name,
            // 'email' => $request->email,
            // 'user_id' => $request->name,
            'created_by' => Auth::user()->id,
            'description' => $request->description,
            'amount' => $request->amount,
            'method' => $request->method,
            'payment_type_id' => $request->payment_type_id
        ];
        OtherPayment::insert($data);
        return redirect()->back();
    }

}
