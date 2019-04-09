<?php

namespace App\Http\Controllers;

use App\Rsr;
use App\Picture;
use App\_helpers\DataOther;
use Auth;
use DB;
use File;
use Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Storage;

class RsrController extends Controller
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



    /**
     * แสดงรายการ ร้านอาหาร
     */
    public function index()
    {
        if(request()->ajax()) {
            return Datatables()
            ->of(Rsr::query())
            ->addColumn('action', function ($rsr) {
                    return '
                        <a uk-icon="icon: plus-circle" uk-tooltip="title: เพิ่มรูปภาพ; pos: top-left" href="'.url('restaurants/uploads/'.Crypt::encryptString($rsr->id)).'"></a>
                        <a uk-icon="icon: file-text" uk-tooltip="title: รายละเอียด; pos: top-left" href="' . route('restaurants.show', Crypt::encryptString($rsr->id)) .'"></a>
                        <a uk-icon="icon: file-edit" uk-tooltip="title: แก้ไข; pos: top-left" href="' . route('restaurants.edit', Crypt::encryptString($rsr->id)) .'"></a>
                        <a uk-icon="icon: trash" uk-tooltip="title: ลบ; pos: top-left" href="javascript:void(0)" onclick="restaurantsDelete(\''.Crypt::encryptString($rsr->id).'\')"></a>
                    '; 
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin/restaurants/list');
    }



    /**
     * แสดงหน้าสร้าง ร้านอาหาร
     */
    public function create()
    {
        return view('admin/restaurants/create');
    }



    /**
     * เช็คชื่อ ร้านอาหาร ห้ามว่าง และ ห้ามซ้ำ
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'unique:f_restaurants']
        ]);
    }



    /**
     * ตรวจสอบข้อมูลภาพหลัก
     */
    protected function validatorMainImg(array $data)
    {
        $messages = [
            'mainImageFile.required' => 'กรุณา เลือกภาพ'
        ];

        return Validator::make($data, [
            'mainImageFile' =>'file|image|mimes:jpeg,jpg,gif,png|max:1024'
        ], $messages);    
    }



    /**
     * สร้าง ร้านอาหาร
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $this->validatorMainImg($request->all())->validate();

        $id = Rsr::create([
            'name' => $request->name,
            'detail' => $request->detail,
            'address' => $request->address,
            'phone' => $request->phone,
            'latlong' => $request->latlon,
            'slug' => DataOther::slugify($request->name),
            'save_user' => Auth::user()->id
        ])->id;

        /* === image === */
        $nameFolder = 'files/rsr-'.$id;

        $directories = Storage::directories($nameFolder);
        if(!$directories){
            Storage::makeDirectory($nameFolder);
        }

        /* === รูปหลัก === */
        if ($request->hasFile('mainImageFile')) {
            $image = $request->file('mainImageFile');
            $name_img = time().$image->getClientOriginalName();

            Storage::disk('local')->putFileAs(
                $nameFolder,
                $image,
                $name_img
            );

            Rsr::where('id', $id)
                ->update([
                    'pic_main_name' => $name_img,
                    'pic_main_path' => $nameFolder.'/'.$name_img
                ]);
        }   
        /* === end รูปหลัก === */

        /* === end image === */

        return redirect('restaurants');
    }



    /**
     * เรียกหน้า upload รูปภาพ ทั่วไป
     */
    public function uploads($id)
    {     
        return view('admin/restaurants/upload', array('id'=> $id) );
    }



    /**
     * upload image other
     */
    public function imagesStore(Request $request)
    {  
        try {
            $id = Crypt::decryptString($request->rsr_id);
        } catch (DecryptException $e) {
            return view('errors.404');
        }

        $nameFolder = 'files/rsr-'.$id.'/other';
        $directories = Storage::directories($nameFolder);
        if(!$directories){
            Storage::makeDirectory($nameFolder);
        }

        $image = $request->file('file');
        $name_img = time().$image->getClientOriginalName();

        Storage::disk('local')->putFileAs(
            $nameFolder,
            $image,
            $name_img
          );

          Picture::create([
            'picture_type' => '3',
            'use_id' => $id,
            'pic_name' => $name_img,
            'pic_path' => $nameFolder.'/'.$name_img,
            'save_user' => Auth::user()->id
        ]);

        return response()->json(['success'=>$name_img]);
    }



    /**
     * view image other
     */
    public function getServerImages($id)
    {
        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return view('errors.404');
        }
        
        $data = Picture::where('use_id', $id)->where('picture_type', '3')->get();

        $nameFolder = 'files/rsr-'.$id.'/other';
        
        $imageAnswer = [];
        foreach ($data as $d) {
            $imageAnswer[] = [
                'original' => $d['pic_name'],
                'server' => asset('public/'.$d['pic_path']),
                'size' => File::size('public/'.$d['pic_path'])    
            ];
        }

        return response()->json([
            'images' => $imageAnswer
        ]);
    }



    /**
     * delect image other
     */
    public function deleteUpload(Request $request)
    {
        $rsr_id = Crypt::decryptString($request->rsr_id);
        $filename = $request->id;

        $path = '';
        $id='';
        $data = Picture::where('use_id', $rsr_id)->where('pic_name', $filename)->get();

        foreach($data as $d){
            $id = $d['id'];
            $path = 'public/'.$d['pic_path'];
        }

        Picture::where('id', $id)->delete();
        
        if( File::exists( $path ) ){
            File::delete( $path );
        }
        
        return Response::json([
            'error' => false,
            'code'  => 200
        ], 200);
    }



    /**
     * แสดงรายละเอียด ร้านอาหาร
     */
    public function show($id)
    {
        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return view('errors.404');
        }
        
        $rsr = Rsr::find($id);
   
        $lat='0';
        $long='0';
        if($rsr['latlong'] != ''){
            $ll = explode(',', $rsr['latlong']);
            $lat = $ll[0];
            $long = $ll[1];
        }

        return view('admin.restaurants.detail', array(
            'rsr' => $rsr
            ,'lat' => $lat
            ,'long' => $long
        ));
    }



    /**
     * แสดงหน้าแก้ไข ร้านอาหาร
     */
    public function edit($id)
    {
        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return view('errors.404');
        }
        
        $rsr = Rsr::find($id);

        $lat='0';
        $long='0';
        if($rsr['latlong'] != ''){
            $ll = explode(',', $rsr['latlong']);
            $lat = $ll[0];
            $long = $ll[1];
        }

        return view('admin.restaurants.edit', array(
            'rsr' => $rsr
            ,'lat' => $lat
            ,'long' => $long
        ));
    }



    /**
     * แก้ไข ร้านอาหาร
     */
    public function update(Request $request, $id)
    {
        try {
            $id = Crypt::decryptString($id);        
        } catch (DecryptException $e) {
            return view('errors.404');
        } 

        if ($request->hasFile('mainImageFile')) {
            $nameFolder = 'files/rsr-'.$id;
            $image = $request->file('mainImageFile');
            $name_img = time().$image->getClientOriginalName();

            /** delete file old */
            $data = Rsr::where('id', $id)->get();
            foreach($data as $d){
                $path_old = 'public/'.$d['pic_main_path'];
            }

            if( File::exists( $path_old ) ){
                File::delete( $path_old );
            }
            /** end delete file old */

            Storage::disk('local')->putFileAs(
                $nameFolder,
                $image,
                $name_img
            );

            Rsr::where('id', $id)
            ->update([
                'pic_main_name' => $name_img,
                'pic_main_path' => $nameFolder.'/'.$name_img
            ]);
        }

        Rsr::where('id', $id)
            ->update([
                'detail' => $request->detail
                , 'address' => $request->address
                , 'phone' => $request->phone
                , 'latlong' => $request->latlon
                , 'save_user' => Auth::user()->id
            ]);
        
        return Redirect::to('restaurants');
    }



    /**
     * ลบ ร้านอาหาร
     */
    public function destroy(Request $request)
    {
        try {
            $id = Crypt::decryptString($request->id);
        } catch (DecryptException $e) {
            return view('errors.404');
        }

        Rsr::where('id', $id)->delete();

        Picture::where('use_id', $id)->where('picture_type', '3')->delete();

        $nameFolder = 'files/rsr-'.$id;
        $path = "public/".$nameFolder;

        if(!empty($path) && is_dir($path) ){
            if(!empty($path.'/other') && is_dir($path.'/other') ){
                DataOther::delete_directory($path.'/other');
            }

            DataOther::delete_directory($path);
        }

        return response()->json(['success'=>"ลบข้อมูลเรียบร้อยแล้ว"]);
    }



}
