<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Category;
use App\District;
use App\Models\Notice;
use App\Post;
use App\Tag;
use App\Upazila;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        // $client =  new Client();
        // return $response = $client->get('https://corona.lmao.ninja/v2/all');
        $data['notices'] = Notice::orderBy('id', 'DESC')->paginate(20);
        $data['page_title'] = 'All Notices';
        return view('notice.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $tags = Tag::all();
        // $categories = Category::all();
        // $districts = District::all();
        // $upazilas = Upazila::all();
        // return $mobile = DB::table('users')
        //         ->where('user_type', 'student')
        //         ->select('phone')
        //         ->get();

        
        $data['page_title'] = 'Create Notices';
        return view('notice.create')->with($data);
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
            'title' => 'required',
            // 'file' => 'required',
            'description' => 'required',

        ]);
        $nTitle = $request->title;
        $ndescription = $request->description;
        if($request->group_id == 1){
            $mobileNO = DB::table('users')
                    ->where('user_type', 'teacher')
                    ->select('phone')
                    ->get();
        }elseif($request->group_id == 2){
            $mobileNO = DB::table('users')
                    ->where('user_type', 'student')
                    ->select('phone')
                    ->get();
        }else{
            $mobileNO = DB::table('incomes')
                    ->select('mobile_no')
                    ->get();
        }
        // return $mobileNO;
        // {"_token":"r2mL3ycqitoBQKtLR96vlP5owCsRyY53WUlZuoGP","title":null,"description":null}

        $notice = Notice::create([
            'title' => $request->title,
            // 'slug' => Str::slug($request->title),
            // 'slug' => preg_replace('/\s+/u', '-', trim($request->title)),
            'file' => 'image.jpg',
            'description' => $request->description,
            'user_id' => Auth::user()->id,
            // 'created a' => Carbon::now(),
        ]);
        $mobile = '';
        if($notice->id != ''){
            if($request->group_id != 3){
                foreach($mobileNO as $row){
                    $mobile .= $row->phone.',';
                }
            }else{
                foreach($mobileNO as $row){
                    $mobile .= $row->mobile_no.',';
                }
                // return $mobile;
            }
            $message = $nTitle  ."\n". $ndescription."\n". 'দারুল ইনসান মাদরাসা';
            $this->send_sms($mobile, $message);
            // return $mobile;
        }

        if($request->hasFile('file')){
            $file = $request->file;
            $file_new_name = time() . '.' . $file->getClientOriginalExtension();
            $file->move('storage/notice/', $file_new_name);
            $notice->file = '/storage/notice/' . $file_new_name;
            $notice->save();
        }

        Session::flash('success', 'notice created successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Notice $notice)
    {
        // return $notice;
        $data['page_title'] = 'Create Notices';
        $data['notice'] = $notice;
        return view('notice.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $tags = Tag::all();
        $categories = Category::all();
        $districts = District::all();
        $upazilas = Upazila::all();
        return view('notice.edit', compact(['post', 'categories', 'tags', 'districts', 'upazilas']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // return $request;
        $this->validate($request, [
            'title' => 'required|unique:posts,title,'.$post->id,
            'image' => 'nullable|image',
            'description' => 'required',
            'video' => 'nullable|url|max:255',
            'reporter' => 'nullable|max:255',

            // 'category' => 'required',
        ]);
        $post->title = $request->title;
        // $post->slug = Str::slug($request->title);
        $post->slug = preg_replace('/\s+/u', '-', trim($request->title));
        $post->description = $request->description;
        $post->category_id = 0;
        $post->video = $request->video;
        $post->district_id = $request->district;
        $post->upazila_id = $request->upazila;
        $post->reporter = $request->reporter;


        $post->tags()->sync($request->tags);
        $post->categories()->sync($request->categories);

        if($request->hasFile('image')){
            if($post->image != null){
                Storage::disk('public')->delete($post->image);
            }
            $image = $request->image;
            $image_new_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move('storage/post/', $image_new_name);
            $post->image = '/storage/post/' . $image_new_name;
        }
        $post->save();

        Session::flash('success', 'Post updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if($post){
            if(file_exists(public_path($post->image))){
                unlink(public_path($post->image));
            }

            $post->delete();
            Session::flash('Post deleted successfully');
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
    public function send_sms($mobile, $message){
         
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
