<?php

namespace App\Http\Controllers;

use App\Garden;
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

class GardenController extends Controller
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
     * แสดงรายการสวนผลไม้
     */
    public function index()
    {
        if(request()->ajax()) {
            return Datatables()
            ->of(Garden::query())
            ->addColumn('action', function ($gardens) {
                    return '
                        <a uk-icon="icon: plus-circle" uk-tooltip="title: เพิ่มรูปภาพ; pos: top-left" href="'.url('gardens/uploads/'.Crypt::encryptString($gardens->id)).'"></a>
                        <a uk-icon="icon: file-text" uk-tooltip="title: รายละเอียด; pos: top-left" href="' . route('gardens.show', Crypt::encryptString($gardens->id)) .'"></a>
                        <a uk-icon="icon: file-edit" uk-tooltip="title: แก้ไข; pos: top-left" href="' . route('gardens.edit', Crypt::encryptString($gardens->id)) .'"></a>
                        <a uk-icon="icon: trash" uk-tooltip="title: ลบ; pos: top-left" href="javascript:void(0)" onclick="gardensDelete(\''.Crypt::encryptString($gardens->id).'\')"></a>
                    '; 
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin/gardens/list');
    }



    /**
     * แสดงหน้าสร้างสวนผลไม้
     */
    public function create()
    {
        return view('admin/gardens/create');
    }



    /**
     * เช็คชื่อสวนผลไม้ห้ามว่าง และ ห้ามซ้ำ
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'unique:f_garden']
        ]);
    }



    /**
     * ตรวจสอบข้อมูลภาพหลักของร้านอาหาร
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
     * สร้างสวนผลไม้
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $this->validatorMainImg($request->all())->validate();

        $id = Garden::create([
            'name' => $request->name,
            'detail' => $request->detail,
            'address' => $request->address,
            'phone' => $request->phone,
            'latlong' => $request->latlon,
            'slug' => DataOther::slugify($request->name),
            'save_user' => Auth::user()->id
        ])->id;

        /* === image === */
        $nameFolder = 'files/garden-'.$id;

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

            Garden::where('id', $id)
                ->update([
                    'pic_main_name' => $name_img,
                    'pic_main_path' => $nameFolder
                ]);
        }   
        /* === end รูปหลัก === */

        /* === end image === */

        return redirect('gardens');
    }



    /**
     * เรียกหน้า upload รูปภาพ ทั่วไป
     */
    public function uploads($id)
    {     
        return view('admin/gardens/upload', array('id'=> $id) );
    }



    /**
     * upload image other
     */
    public function imagesStore(Request $request)
    {  
        try {
            $id = Crypt::decryptString($request->garden_id);
        } catch (DecryptException $e) {
            return view('errors.404');
        }

        $nameFolder = 'files/garden-'.$id.'/other';
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
            'picture_type' => '1',
            'use_id' => $id,
            'pic_name' => $name_img,
            'pic_path' => $nameFolder,
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
        
        $data = Picture::where('use_id', $id)->get();

        $nameFolder = 'files/garden-'.$id.'/other';
        
        $imageAnswer = [];
        foreach ($data as $d) {
            $imageAnswer[] = [
                'original' => $d['pic_name'],
                'server' => '../../public/'.$d['pic_path'].'/'.$d['pic_name'],
                'size' => File::size('public/'.$d['pic_path'].'/'.$d['pic_name'])     
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
        $garden_id = Crypt::decryptString($request->garden_id);
        $filename = $request->id;

        $path = '';
        $id='';
        $data = Picture::where('use_id', $garden_id)->where('pic_name', $filename)->get();

        foreach($data as $d){
            $id = $d['id'];
            $path = 'public/'.$d['pic_path'].'/'.$d['pic_name'];
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
     * แสดงรายละเอียดสวนผลไม้
     */
    public function show($id)
    {
        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return view('errors.404');
        }
        
        $garden = Garden::find($id);
   
        $lat='0';
        $long='0';
        if($garden['latlong'] != ''){
            $ll = explode(',', $garden['latlong']);
            $lat = $ll[0];
            $long = $ll[1];
        }

        return view('admin.gardens.detail', array(
            'garden' => $garden
            ,'lat' => $lat
            ,'long' => $long
        ));
    }



    /**
     * แสดงหน้าแก้ไขสวนผลไม้
     */
    public function edit($id)
    {
        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return view('errors.404');
        }
        
        $garden = Garden::find($id);

        $lat='0';
        $long='0';
        if($garden['latlong'] != ''){
            $ll = explode(',', $garden['latlong']);
            $lat = $ll[0];
            $long = $ll[1];
        }

        return view('admin.gardens.edit', array(
            'garden' => $garden
            ,'lat' => $lat
            ,'long' => $long
        ));
    }



    /**
     * แก้ไขสวนผลไม้
     */
    public function update(Request $request, $id)
    {
        try {
            $id = Crypt::decryptString($id);        
        } catch (DecryptException $e) {
            return view('errors.404');
        } 

        if ($request->hasFile('mainImageFile')) {
            $nameFolder = 'files/garden-'.$id;
            $image = $request->file('mainImageFile');
            $name_img = time().$image->getClientOriginalName();

            /** delete file old */
            $data = Garden::where('id', $id)->get();
            foreach($data as $d){
                $path_old = 'public/'.$d['pic_main_path'].'/'.$d['pic_main_name'];
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

            Garden::where('id', $id)
            ->update([
                'pic_main_name' => $name_img,
                'pic_main_path' => $nameFolder
            ]);
        }

        Garden::where('id', $id)
            ->update([
                'detail' => $request->detail
                , 'address' => $request->address
                , 'phone' => $request->phone
                , 'latlong' => $request->latlon
                , 'save_user' => Auth::user()->id
            ]);
        
        return Redirect::to('gardens');
    }



    /**
     * ลบสวนดอกไม้
     */
    public function destroy(Request $request)
    {
        try {
            $id = Crypt::decryptString($request->id);
        } catch (DecryptException $e) {
            return view('errors.404');
        }

        Garden::where('id', $id)->delete();

        Picture::where('use_id', $id)->delete();

        $nameFolder = 'files/garden-'.$id;
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
