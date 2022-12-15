<?php

namespace App\Http\Controllers\SupportTeam;

use App\Helpers\Qs;
use App\Helpers\Mk;
use App\Http\Requests\Badrin\BadrinRecordCreate;
use App\Http\Requests\Badrin\BadrinRecordUpdate;
use App\Repositories\LocationRepo;
use App\Repositories\MyClassRepo;
use App\Repositories\BadrinRepo;
use App\Repositories\UserRepo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Helpers\Pay;
use Illuminate\Database\QueryException;
use Symfony\Component\Console\Exception\InvalidArgumentException;

use App\Models\SinglePayment;
use App\Models\SinglePaymentRecord;
use App\Models\SingleReceipt;
use App\User;
use Illuminate\Support\Facades\DB;

class BadrinRecordController extends Controller
{
    protected $loc, $my_class, $user, $badrin;

   public function __construct(LocationRepo $loc, MyClassRepo $my_class, UserRepo $user, BadrinRepo $badrin)
   {
       $this->middleware('teamSA', ['only' => ['edit','update', 'reset_pass', 'create', 'store', 'graduated'] ]);
       $this->middleware('super_admin', ['only' => ['destroy',] ]);

        $this->loc = $loc;
        $this->my_class = $my_class;
        $this->user = $user;
        $this->badrin = $badrin;
   }

    public function reset_pass($st_id)
    {
        $st_id = Qs::decodeHash($st_id);
        $data['password'] = Hash::make('badrin');
        $this->user->update($st_id, $data);
        return back()->with('flash_success', __('msg.p_reset'));
    }

    public function create()
    {
        $data['my_classes'] = $this->my_class->badri();
        $data['parents'] = $this->user->getUserByType('parent');
        $data['dorms'] = $this->badrin->getAllDorms();
        $data['states'] = $this->loc->getStates();
        $data['divisions'] = $this->loc->getDivisions();
        $data['districts'] = $this->loc->getDistricts();
        $data['nationals'] = $this->loc->getAllNationals();

        return view('pages.support_team.badrins.add', $data);
    }

    public function store(BadrinRecordCreate $req)
    {
        // return response()->json('msg.store_ok');
       $data =  $req->only(Qs::getUserRecord()); // badrin User info
       $sr =  $req->only(Qs::getBadrinData());//badrin info
       $lastUserId = User::orderby('id', 'DESC')->first();

       $ct = $this->my_class->findTypeByClass($req->my_class_id)->code;//class type
       /* $ct = ($ct == 'J') ? 'JSS' : $ct;
       $ct = ($ct == 'S') ? 'SS' : $ct;*/
       $data['user_type'] = 'badrin';
       $data['name'] = ucwords($req->name);
       $data['code'] = strtoupper(Str::random(10));
       $data['password'] = Hash::make('12345678');
       $data['photo'] = Qs::getDefaultUserImage();
       $adm_no = $req->adm_no;
       $data['username'] = strtoupper(Qs::getAppCode().'/'.$ct.'/'.$sr['year_admitted'].'/'.$lastUserId->id. '000' .($adm_no ?: mt_rand(1000, 99999)));
       
       if($req->hasFile('photo')) {
           $photo = $req->file('photo');
           $f = Qs::getFileMetaData($photo);
           $f['name'] = 'photo.' . $f['ext'];
           $f['path'] = $photo->storeAs(Qs::getUploadPath('badrin').$data['code'], $f['name']);
           $data['photo'] = asset('storage/' . $f['path']);
        //    dd($data['photo']);
        }
        
        $user = $this->user->create($data); // Create User
        
        $sr['adm_no'] = $data['username'];
        $sr['user_id'] = $user->id;
        $sr['member_no'] = $sr['member_no'];
        $sr['session'] = Qs::getSetting('current_session');
        $badrin = $this->badrin->createRecord($sr); // Create badrin
        $mk = '';
        for ($i=0; $i<sizeof($req->input('amount')); $i++) {
            if($req->amount[$i] != null){
                $mk .= $i . ',';
                $singlePay['amount'] = $req->amount[$i];
                $singlePay['description'] = $req->description[$i];
                $singlePay['method'] = $req->method[$i];
                $singlePay['my_class_id'] = $req->my_class_id;
                $singlePay['ref_no'] = Pay::genRefCode();
                $singlePay['year'] = Qs::getSetting('current_session');
                // $singlePay['badrin_id'] = $badrin->id;
                $singlePay['badrin_id'] = $user->id;
                $singlePay['title'] = $req->title[$i];
                $payment = SinglePayment::create($singlePay); // Create Payment
                // $payment_id = DB::table('single_payments')->insertGetId($singlePay); // Create Payment
                
                $singlePayRecords['payment_id'] = $payment->id;
                // $singlePayRecords['payment_id'] = $payment_id;
                $singlePayRecords['badrin_id'] = $user->id;
                $singlePayRecords['my_class_id'] = $req->my_class_id;
                $singlePayRecords['ref_no'] = mt_rand(100000, 99999999);
                $singlePayRecords['amt_paid'] = $req->paid[$i] == 'yes' ?  $req->amount[$i] : NULL;
                $singlePayRecords['balance'] = $req->paid[$i] == 'yes' ?  0 : NULL;
                $singlePayRecords['paid'] = $req->paid[$i] == 'yes' ?  1 : 0;
                $singlePayRecords['year'] = Qs::getSetting('current_session');
                $payment_record = SinglePaymentRecord::create($singlePayRecords); // Create Payment Record
                // $payment_record_id = DB::table('single_payment_records')->insertGetId($singlePayRecords); // Create Payment Record
                if($req->paid[$i] == 'yes'){
                    $single_receipts['single_payment_records_id'] = $payment_record->id;
                    // $single_receipts['single_payment_records_id'] = $payment_record_id;
                    $single_receipts['amt_paid'] = $req->amount[$i];
                    $single_receipts['balance'] = 0;
                    $single_receipts['year'] = Qs::getSetting('current_session');
                    SingleReceipt::create($single_receipts); // Create Payment Record
                    // $single_receipts = DB::table('single_receipts')->insertGetId($single_receipts); // Create Payment Record
                    // dd($single_receipts);
                    // dd($single_receipts);
                }
            }
        }
        return Qs::jsonStoreOk();
    }

    public function listByClass($class_id)
    {
        $data['my_class'] = $mc = $this->my_class->getMC(['id' => $class_id])->first();
        $data['badrins'] = $this->badrin->findBadrinsByClass($class_id);
        $data['sections'] = $this->my_class->getClassSections($class_id);
        // return $data;
        return is_null($mc) ? Qs::goWithDanger() : view('pages.support_team.badrins.list', $data);
    }


    public function show($sr_id)
    {
        $sr_id = Qs::decodeHash($sr_id);
        if(!$sr_id){return Qs::goWithDanger();}

        $data['sr'] = $this->badrin->getRecord(['id' => $sr_id])->first();

        /* Prevent Other badrins/Parents from viewing Profile of others */
        if(Auth::user()->id != $data['sr']->user_id && !Qs::userIsTeamSAT() && !Qs::userIsMyChild($data['sr']->user_id, Auth::user()->id)){
            return redirect(route('dashboard'))->with('pop_error', __('msg.denied'));
        }

        return view('pages.support_team.badrins.show', $data);
    }

    public function edit($sr_id)
    {
        $sr_id = Qs::decodeHash($sr_id);
        if(!$sr_id){return Qs::goWithDanger();}

        $data['sr'] = $this->badrin->getRecord(['id' => $sr_id])->first();
        $data['my_classes'] = $this->my_class->all();
        $data['parents'] = $this->user->getUserByType('parent');
        $data['dorms'] = $this->badrin->getAllDorms();
        $data['divisions'] = $this->loc->getDivisions();
        $data['districts'] = $this->loc->getDistricts();
        $data['states'] = $this->loc->getStates();
        $data['nationals'] = $this->loc->getAllNationals();
        return view('pages.support_team.badrins.edit', $data);
    }

    public function update(BadrinRecordUpdate $req, $sr_id)
    {
        $sr_id = Qs::decodeHash($sr_id);
        if(!$sr_id){return Qs::goWithDanger();}

        $sr = $this->badrin->getRecord(['id' => $sr_id])->first();
        $d =  $req->only(Qs::getUserRecord());
        $d['name'] = ucwords($req->name);

        if($req->hasFile('photo')) {
            $photo = $req->file('photo');
            $f = Qs::getFileMetaData($photo);
            $f['name'] = 'photo.' . $f['ext'];
            $f['path'] = $photo->storeAs(Qs::getUploadPath('badrin').$sr->user->code, $f['name']);
            $d['photo'] = asset('storage/' . $f['path']);
        }

        $this->user->update($sr->user->id, $d); // Update User Details

        $srec = $req->only(Qs::getBadrinData());

        $this->badrin->updateRecord($sr_id, $srec); // Update St Rec

        /*** If Class/Section is Changed in Same Year, Delete Marks/ExamRecord of Previous Class/Section ****/
        Mk::deleteOldRecord($sr->user->id, $srec['my_class_id']);

        return Qs::jsonUpdateOk();
    }

    public function destroy($st_id)
    {
        $st_id = Qs::decodeHash($st_id);
        if(!$st_id){return Qs::goWithDanger();}

        $sr = $this->badrin->getRecord(['user_id' => $st_id])->first();
        $path = Qs::getUploadPath('badrin').$sr->user->code;
        Storage::exists($path) ? Storage::deleteDirectory($path) : false;
        $userDel = $this->user->delete($sr->user->id);
        if($userDel){
            DB::table('badrin_records')->where('id', $sr->id)->delete();
        }

        return back()->with('flash_success', __('msg.del_ok'));
    }

}
