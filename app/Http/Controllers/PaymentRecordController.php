<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Category;
use App\District;
use App\Models\Notice;
use App\Models\PaymentRecord;
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

class PaymentRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        // PaymentRecord::orderBy('id', 'desc')->paginate(20);
        // $client =  new Client();
        // return $response = $client->get('https://corona.lmao.ninja/v2/all');
        $data['Receipt'] = Receipt::orderBy('id', 'DESC')->paginate(20);
        $data['SingleReceipt'] = SingleReceipt::orderBy('id', 'DESC')->paginate(20);
        $data['page_title'] = 'All Payment Receipts';
        // return $data;

        return view('pages.support_team.payments.payment_records')->with($data);
    }

}
