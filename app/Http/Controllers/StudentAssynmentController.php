<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Category;
use App\District;
use App\Helpers\Qs;
use App\Models\Assynment;
use App\Models\Notice;
use App\Post;
use App\Repositories\MyClassRepo;
use App\Tag;
use App\Upazila;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepo;
use App\Models\StudentAssynment;

class StudentAssynmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $my_class, $user;

    public function __construct(MyClassRepo $my_class, UserRepo $user)
    {
        // $this->middleware('teamSA', ['except' => ['destroy',] ]);
        // $this->middleware('super_admin', ['only' => ['destroy',] ]);

        $this->my_class = $my_class;
        $this->user = $user;
    }


    public function index(Request $request)
    {
        // $client =  new Client();
        // return $response = $client->get('https://corona.lmao.ninja/v2/all');
        $data['assynment'] = Assynment::findOrFail($request->assy_id);
        if(Auth::user()->user_type ==  'student'){
            $data['assynments'] = StudentAssynment::orderBy('id', 'DESC')->where('assynment_id', $request->assy_id)->paginate(20);
        }else{
            $data['assynments'] = StudentAssynment::orderBy('id', 'DESC')->where('assynment_id', $request->assy_id)->paginate(20);
        }
        $data['page_title'] = 'Submitted Assynment List';
        return view('student_assynment.index')->with($data);
    }

    public function create(Request $request)
    {
        // return $request;
        $d['assynment'] = Assynment::findOrFail($request->assy_id);
        // $d['my_classes'] = $this->my_class->all();
        // $d['subjects'] = $this->my_class->getAllSubjects();
        $d['selected'] = false;
        $d['page_title'] = 'Submit Assynment';
        return view('student_assynment.create')->with($d);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $this->validate($request, [
            "file"=>"required",
        ]);
        $assynment = StudentAssynment::create([
            'student_id' => Auth::user()->id,
            'file' => 'image.jpg',
            'assynment_id' => $request->assy_id,
            'message' => $request->message,
        ]);
        if($request->hasFile('file')){
            $file = $request->file;
            $file_new_name = time() . '.' . $file->getClientOriginalExtension();
            $file->move('storage/st_assynment/', $file_new_name);
            $assynment->file = '/storage/st_assynment/' . $file_new_name;
            $assynment->save();
        }
        return redirect()->back()->with('flash_success', __('msg.store_ok'));;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(StudentAssynment $Assynment, $id)
    {
        $Assynment = StudentAssynment::findOrFail($id);
        $page_title = 'Submitted Assynment Show';
        return view('student_assynment.show', compact('Assynment', 'page_title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Assynment $assynment)
    {

        // return $assynment;
        $d['assynment'] = $assynment;
        $d['my_classes'] = $this->my_class->all();
        // $d['subjects'] = $this->my_class->getAllSubjects();
        $d['selected'] = false;
        $d['page_title'] = 'Edit assynment';
        return view('student_assynment.edit')->with($d);
        // return $assynment;
        // return view('student_assynment.edit', compact(['assynment']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assynment $assynment)
    {
        // return $request;
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            "my_class_id"=>"required",
            "subject_id"=>"required",

        ]);

        $assynment->update([
            'title' => $request->title,
            'file' => 'image.jpg',
            'description' => $request->description,
            'user_id' => Auth::user()->id,
            'my_class_id' => $request->my_class_id,
            'subject_id' => $request->subject_id,
            'sub_date' => $request->sub_date,
        ]);
        if($request->hasFile('file')){
            $file = $request->file;
            $file_new_name = time() . '.' . $file->getClientOriginalExtension();
            $file->move('storage/assynment/', $file_new_name);
            $assynment->file = '/storage/assynment/' . $file_new_name;
            $assynment->save();
        }
        return redirect()->back()->with('flash_success', __('msg.update_ok'));;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assynment $Assynment)
    {
        if($Assynment){
            if(file_exists(public_path($Assynment->image))){
                unlink(public_path($Assynment->file));
            }

            $Assynment->delete();
            Session::flash('Assynment deleted successfully');
        }

        return redirect()->back();
    }

    public function upazilas(Request $request) {

        if ($request->ajax()) {
            if($request->id == null){
                return response()->json([
                    'upazilas' => Upazila::all()
                ]);
            }
            return response()->json([
                'upazilas' => Upazila::where('district_id', $request->id)->get()
            ]);
        }
    }

}
