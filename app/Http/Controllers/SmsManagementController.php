<?php

namespace App\Http\Controllers;

use App\Models\SmsManagement;
use App\Http\Controllers\Controller;
use App\Repositories\MyClassRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SmsManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $my_class;

   public function __construct(MyClassRepo $my_class)
   {
        $this->my_class = $my_class;
       
   }public function index()
    {
        // dd("INDEX");
        $data['smses'] = SmsManagement::orderBy('id', 'DESC')->paginate(20);
        $data['page_title'] = 'All Sent SMS';
        return view('sms.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd("create");
        $data['my_classes'] = $this->my_class->all();
        $data['page_title'] = 'Create SMS';
        // return $data;
        return view('sms.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $this->validate($request, [
            'title' => 'required',
            'group_id' => 'required',
            'description' => 'required',

        ]);
        if($request->group_id == 2) {
            $this->validate($request, [
                'my_class' => 'required',

            ]);
        }

        // return $request;
        $nTitle = $request->title;
        $ndescription = $request->description;
        if($request->group_id == 1){
            $mobileNO = DB::table('users')
                    ->where('user_type', 'teacher')
                    ->select('phone')
                    ->get();
        }elseif($request->group_id == 2){

            $studentUserId = DB::table('student_records')
                    ->where('my_class_id', $request->my_class)
                    ->select('user_id')
                    ->get();
            foreach ($studentUserId as $key => $value) {
                    $mobileNO = DB::table('users')
                        ->where('id', $value->user_id)
                        ->select('phone')
                        ->get();
            }
        }else{
            $mobileNO = DB::table('users')
                    ->where('user_type', 'badrin')
                    ->select('phone')
                    ->get();
        }
        // {"_token":"r2mL3ycqitoBQKtLR96vlP5owCsRyY53WUlZuoGP","title":null,"description":null}

        $sms = SmsManagement::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::user()->id,
        ]);
        $mobile = '';
        if($sms->id != ''){
        // dd($sms->id);
            if(!empty($mobileNO)){
                foreach($mobileNO as $row){
                    if($request->group_id != 3){
                        foreach($mobileNO as $row){
                            $mobile .= $row->phone.',';
                        }
                    }else{
                        foreach($mobileNO as $row){
                            $mobile .= $row->phone.',';
                        }
                        // return $mobile;
                    }
                }
            }
            $message = $nTitle  ."\n". $ndescription."\n". 'দারুল ইনসান মাদরাসা';
            // return $mobile;
            $this->send_sms($mobile, $message);
            
        }

        Session::flash('success', 'SMS created and sent successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SmsManagement  $smsManagement
     * @return \Illuminate\Http\Response
     */
    public function show(SmsManagement $smsManagement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SmsManagement  $smsManagement
     * @return \Illuminate\Http\Response
     */
    public function edit(SmsManagement $smsManagement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SmsManagement  $smsManagement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SmsManagement $smsManagement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SmsManagement  $smsManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy(SmsManagement $smsManagement)
    {
        //
    }
    public function send_sms($mobile, $message){
         // echo "<pre>"; print_r($mobile.' , '.$message);exit('zuel');
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
