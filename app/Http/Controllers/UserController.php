<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use DB;
use Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Yajra\Datatables\Facades\Datatables;

class UserController extends Controller
{
    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    

    /**
     * แสดงรายการผู้ใช้งาน
     */
    public function index()
    {
        if(request()->ajax()) {
            return Datatables()
            ->of(User::query())
            ->addColumn('action', function ($user) {
                    return '
                        <a uk-icon="icon: file-text" uk-tooltip="title: รายละเอียด; pos: top-left" href="' . route('users.show', Crypt::encryptString($user->id)) .'"></a>
                        <a uk-icon="icon: file-edit" uk-tooltip="title: แก้ไข; pos: top-left" href="' . route('users.edit', Crypt::encryptString($user->id)) .'"></a>
                        <a uk-icon="icon: trash" uk-tooltip="title: ลบ; pos: top-left" href="javascript:void(0)" onclick="userDelete(\''.Crypt::encryptString($user->id).'\')"></a>
                    '; 
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin/users/list');
    }



    /**
     * แสดงหน้าสร้างผู้ใช้งาน
     */
    public function create()
    {
        $level = DB::table( 'f_users_level' )->select( DB::raw('id, level') )->orderby('id', 'desc')->get();
        $level_name=[];
        foreach ($level as $key => $value) {                    
            $level_name[$value->id] = $value->level;
        }  

        $status = DB::table( 'f_users_status' )->select( DB::raw('code, status') )->orderby('code', 'desc')->get();
        $status_name=[];
        foreach ($status as $key => $value) {                    
            $status_name[$value->code] = $value->status;
        }  

        return view('admin.users.create', array('level' => $level_name, 'status' => $status_name ));
    }



    /**
     * ตรวจสอบความถูกต้องข้อมูลผู้ใช้งาน
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'max:100', 'unique:f_users'],
            'password' => ['required', 'max:255', 'confirmed'],
            'fullname' => ['required']
        ]);
    }



    /**
     * สร้างผู้ใช้งาน 1
     */
    protected function createUser(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
            'fullname' => $data['fullname'],
            'email' => $data['email'],
            'level' => $data['level'],
            'status' => $data['status'],
        ]);
    }



    /**
     * สร้างผู้ใช้งาน 2
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->createUser($request->all())));
        return $this->registered($request, $user)
            ?: redirect('/users');  
    }



    /**
     * แสดงหน้ารายละเอียดผู้ใช้งาน
     */
    public function show($id)
    {
        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return view('errors.404');
        }
        
        $user = User::find($id);

        return view('admin.users.detail', array('user' => $user ));
    }



    /**
     * แสดงหน้าแก้ไขผู้ใช้งาน
     */
    public function edit($id)
    {
        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return view('errors.404');
        }
        
        $user = User::find($id);

        $level = DB::table( 'f_users_level' )->select( DB::raw('id, level') )->get();
        $level_name=[];
        foreach ($level as $key => $value) {                    
            $level_name[$value->id] = $value->level;
        }  

        $status = DB::table( 'f_users_status' )->select( DB::raw('code, status') )->get();
        $status_name=[];
        foreach ($status as $key => $value) {                    
            $status_name[$value->code] = $value->status;
        }  

        return view('admin.users.edit', array('user' => $user, 'level' => $level_name, 'status' => $status_name ));
    }



    /**
     * แก้ไขผู้ใชงาน
     */
    public function update(Request $request, $id)
    {
        try {
            $id = Crypt::decryptString($id);        
        } catch (DecryptException $e) {
            return view('errors.404');
        } 

        if($request->password != '' && $request->password_confirmation != ''){
            if($request->password == $request->password_confirmation){
                $users = DB::table('f_users')->where('id', $id)->first();
                User::where('id', $id)->update(['email' => $request->email,'level' => $request->level, 'status' => $request->status, 'password' => bcrypt($request->password) ]);
            }else{
                return redirect()->back()->withErrors(['password'=>'กรุณาเช็ครหัสผ่านอีกครั้ง'])->withInput();
            }
        }

        if($request->password == '' && $request->password_confirmation != ''){
            return redirect()->back()->withErrors(['password'=>'กรุณาเช็ครหัสผ่านอีกครั้ง'])->withInput();
        }

        if($request->password != '' && $request->password_confirmation == ''){
            return redirect()->back()->withErrors(['password'=>'กรุณาเช็ครหัสผ่านอีกครั้ง'])->withInput();
        }

        if($request->password == '' && $request->password_confirmation == ''){
            $users = DB::table('f_users')->where('id', $id)->first();
            User::where('id', $id)->update(['email' => $request->email,'level' => $request->level, 'status' => $request->status]);
        }

        return Redirect::to('users');
    }



    /**
     * ลบผู้ใช้งาน
     */
    public function destroy(Request $request)
    {
        try {
            $id = Crypt::decryptString($request->id);
        } catch (DecryptException $e) {
            return view('errors.404');
        }

        User::where('id', $id)->delete();

        return response()->json(['success'=>"ลบข้อมูลเรียบร้อยแล้ว"]);
    }



}
