<?php

namespace App\Http\Controllers;

use App\Contact;
use Auth;
use DB;
use Redirect;
use Illuminate\Http\Request;

class ContactController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }



    public function index()
    {
        $contact = Contact::where('id', 1)->first();
        return view('admin/contact/contact', array('contact' => $contact));
    }



    public function store(Request $request)
    {
        if($request->id == 0){
            Contact::create([
                'about' => $request->about,
                'phone' => $request->phone,
                'facebook' => $request->facebook,
                'instagram' => $request->instagram,
                'twitter' => $request->twitter,
                'address' => $request->address
            ]);
        }else{
            Contact::where('id', $request->id)
            ->update([
                'about' => $request->about,
                'phone' => $request->phone,
                'facebook' => $request->facebook,
                'instagram' => $request->instagram,
                'twitter' => $request->twitter,
                'address' => $request->address
            ]);
        }   

        return redirect()->back()->withErrors(['success'=>'บันทึกข้อมูลสำเร็จ'])->withInput();
    }


}
