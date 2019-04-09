<?php

namespace App\Http\Controllers;

use App\Hotel;
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

class HotelController extends Controller
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
     * แสดงรายการที่พัก
     */
    public function index()
    {
        if(request()->ajax()) {
            return Datatables()
            ->of(Hotel::query())
            ->addColumn('action', function ($hotels) {
                    return '
                        <a uk-icon="icon: plus-circle" uk-tooltip="title: เพิ่มรูปภาพ; pos: top-left" href="'.url('hotels/uploads/'.Crypt::encryptString($hotels->id)).'"></a>
                        <a uk-icon="icon: file-text" uk-tooltip="title: รายละเอียด; pos: top-left" href="' . route('hotels.show', Crypt::encryptString($hotels->id)) .'"></a>
                        <a uk-icon="icon: file-edit" uk-tooltip="title: แก้ไข; pos: top-left" href="' . route('hotels.edit', Crypt::encryptString($hotels->id)) .'"></a>
                        <a uk-icon="icon: trash" uk-tooltip="title: ลบ; pos: top-left" href="javascript:void(0)" onclick="hotelsDelete(\''.Crypt::encryptString($hotels->id).'\')"></a>
                    '; 
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin/hotels/list');
    }



    /**
     * แสดงหน้าสร้างที่พัก
     */
    public function create()
    {
        return view('admin/hotels/create');
    }



    /**
     * เช็คชื่อ ที่พัก ห้ามว่าง และ ห้ามซ้ำ
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'unique:f_hotels']
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
     * สร้าง ที่พัก
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $this->validatorMainImg($request->all())->validate();

        $id = Hotel::create([
            'name' => $request->name,
            'detail' => $request->detail,
            'address' => $request->address,
            'phone' => $request->phone,
            'latlong' => $request->latlon,
            'slug' => DataOther::slugify($request->name),
            'save_user' => Auth::user()->id
        ])->id;

        /* === image === */
        $nameFolder = 'files/hotel-'.$id;

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

            Hotel::where('id', $id)
                ->update([
                    'pic_main_name' => $name_img,
                    'pic_main_path' => $nameFolder.'/'.$name_img
                ]);
        }   
        /* === end รูปหลัก === */

        /* === end image === */

        return redirect('hotels');
    }



    /**
     * เรียกหน้า upload รูปภาพ ทั่วไป
     */
    public function uploads($id)
    {     
        return view('admin/hotels/upload', array('id'=> $id) );
    }



    /**
     * upload image other
     */
    public function imagesStore(Request $request)
    {  
        try {
            $id = Crypt::decryptString($request->hotel_id);
        } catch (DecryptException $e) {
            return view('errors.404');
        }

        $nameFolder = 'files/hotel-'.$id.'/other';
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
            'picture_type' => '2',
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
        
        $data = Picture::where('use_id', $id)->where('picture_type', '2')->get();

        $nameFolder = 'files/hotel-'.$id.'/other';
        
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
        $hotel_id = Crypt::decryptString($request->hotel_id);
        $filename = $request->id;

        $path = '';
        $id='';
        $data = Picture::where('use_id', $hotel_id)->where('pic_name', $filename)->get();

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
     * แสดงรายละเอียด ที่พัก
     */
    public function show($id)
    {
        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return view('errors.404');
        }
        
        $hotel = Hotel::find($id);
   
        $lat='0';
        $long='0';
        if($hotel['latlong'] != ''){
            $ll = explode(',', $hotel['latlong']);
            $lat = $ll[0];
            $long = $ll[1];
        }

        return view('admin.hotels.detail', array(
            'hotel' => $hotel
            ,'lat' => $lat
            ,'long' => $long
        ));
    }



    /**
     * แสดงหน้าแก้ไข ที่พัก
     */
    public function edit($id)
    {
        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return view('errors.404');
        }
        
        $hotel = Hotel::find($id);

        $lat='0';
        $long='0';
        if($hotel['latlong'] != ''){
            $ll = explode(',', $hotel['latlong']);
            $lat = $ll[0];
            $long = $ll[1];
        }

        return view('admin.hotels.edit', array(
            'hotel' => $hotel
            ,'lat' => $lat
            ,'long' => $long
        ));
    }



    /**
     * แก้ไข ที่พัก
     */
    public function update(Request $request, $id)
    {
        try {
            $id = Crypt::decryptString($id);        
        } catch (DecryptException $e) {
            return view('errors.404');
        } 

        if ($request->hasFile('mainImageFile')) {
            $nameFolder = 'files/hotel-'.$id;
            $image = $request->file('mainImageFile');
            $name_img = time().$image->getClientOriginalName();

            /** delete file old */
            $data = Hotel::where('id', $id)->get();
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

            Hotel::where('id', $id)
            ->update([
                'pic_main_name' => $name_img,
                'pic_main_path' => $nameFolder.'/'.$name_img
            ]);
        }

        Hotel::where('id', $id)
            ->update([
                'detail' => $request->detail
                , 'address' => $request->address
                , 'phone' => $request->phone
                , 'latlong' => $request->latlon
                , 'save_user' => Auth::user()->id
            ]);
        
        return Redirect::to('hotels');
    }



    /**
     * ลบ ที่พัก
     */
    public function destroy(Request $request)
    {
        try {
            $id = Crypt::decryptString($request->id);
        } catch (DecryptException $e) {
            return view('errors.404');
        }

        Hotel::where('id', $id)->delete();

        Picture::where('use_id', $id)->where('picture_type', '2')->delete();

        $nameFolder = 'files/hotel-'.$id;
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
