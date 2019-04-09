<?php

namespace App\Http\Controllers;

use App\Event;
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

class EventController extends Controller
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
     * แสดงรายการ กิจกรรม
     */
    public function index()
    {
        if(request()->ajax()) {
            $event_data = DB::table('f_events')
            ->leftJoin('f_garden', 'f_garden.id', '=', 'f_events.garden_id')
            ->select(db::raw('f_events.*'), db::raw('f_garden.name as garden_name'))
            ->get();

            return Datatables()
            ->of($event_data)
            ->addColumn('action', function ($event) {
                    return '
                        <a uk-icon="icon: plus-circle" uk-tooltip="title: เพิ่มรูปภาพ; pos: top-left" href="'.url('events/uploads/'.Crypt::encryptString($event->id)).'"></a>
                        <a uk-icon="icon: file-text" uk-tooltip="title: รายละเอียด; pos: top-left" href="' . route('events.show', Crypt::encryptString($event->id)) .'"></a>
                        <a uk-icon="icon: file-edit" uk-tooltip="title: แก้ไข; pos: top-left" href="' . route('events.edit', Crypt::encryptString($event->id)) .'"></a>
                        <a uk-icon="icon: trash" uk-tooltip="title: ลบ; pos: top-left" href="javascript:void(0)" onclick="eventsDelete(\''.Crypt::encryptString($event->id).'\')"></a>
                    '; 
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin/events/list');
    }




    /**
     * แสดงหน้าสร้าง กิจกรรม
     */
    public function create()
    {
        $garden_data = Garden::select('id', 'name')->orderby('name', 'asc')->get();
        $garden=[];
        foreach ($garden_data as $key => $value) {                    
            $garden[$value->id] = $value->name;
        }

        return view('admin/events/create', array('garden'=>$garden));
    }



    /**
     * เช็คชื่อ รายละเอียด กิจกรรม ห้ามว่าง
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'garden_id' => ['required'],
            'name' => ['required']
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
     * สร้าง กิจกรรม
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $this->validatorMainImg($request->all())->validate();

        $id = Event::create([
            'garden_id' => $request->garden_id,
            'name' => $request->name,
            'detail' => $request->detail,
            'slug' => DataOther::slugify($request->name),
            'save_user' => Auth::user()->id
        ])->id;

        /* === image === */
        $nameFolder = 'files/event-'.$id;

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

            Event::where('id', $id)
                ->update([
                    'pic_main_name' => $name_img,
                    'pic_main_path' => $nameFolder.'/'.$name_img
                ]);
        }   
        /* === end รูปหลัก === */

        /* === end image === */

        return redirect('events');
    }



    /**
     * เรียกหน้า upload รูปภาพ ทั่วไป
     */
    public function uploads($id)
    {     
        return view('admin/events/upload', array('id'=> $id) );
    }




    /**
     * upload image other
     */
    public function imagesStore(Request $request)
    {  
        try {
            $id = Crypt::decryptString($request->event_id);
        } catch (DecryptException $e) {
            return view('errors.404');
        }

        $nameFolder = 'files/event-'.$id.'/other';
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
            'picture_type' => '4',
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
        
        $data = Picture::where('use_id', $id)->where('picture_type', '4')->get();

        $nameFolder = 'files/event-'.$id.'/other';
        
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
        $event_id = Crypt::decryptString($request->event_id);
        $filename = $request->id;

        $path = '';
        $id='';
        $data = Picture::where('use_id', $event_id)->where('pic_name', $filename)->get();

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
     * แสดงรายละเอียด กิจกรรม
     */
    public function show($id)
    {
        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return view('errors.404');
        }

        $event = DB::table('f_events')
            ->leftJoin('f_garden', 'f_garden.id', '=', 'f_events.garden_id')
            ->select(db::raw('f_events.*'), db::raw('f_garden.name as garden_name'))
            ->where('f_events.id', $id)
            ->get()->first();

        return view('admin.events.detail', array(
            'event' => $event
        ));
    }



    /**
     * แสดงหน้าแก้ไข กิจกรรม
     */
    public function edit($id)
    {
        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return view('errors.404');
        }
        
        $event = Event::find($id);

        $garden_data = Garden::select('id', 'name')->orderby('name', 'asc')->get();
        $garden=[];
        foreach ($garden_data as $key => $value) {                    
            $garden[$value->id] = $value->name;
        }

        return view('admin.events.edit', array(
            'event' => $event
            ,'garden' => $garden
        ));
    }



    /**
     * แก้ไข กิจกรรม
     */
    public function update(Request $request, $id)
    {
        try {
            $id = Crypt::decryptString($id);        
        } catch (DecryptException $e) {
            return view('errors.404');
        } 

        if ($request->hasFile('mainImageFile')) {
            $nameFolder = 'files/event-'.$id;
            $image = $request->file('mainImageFile');
            $name_img = time().$image->getClientOriginalName();

            /** delete file old */
            $data = Event::where('id', $id)->get();
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

            Event::where('id', $id)
            ->update([
                'pic_main_name' => $name_img,
                'pic_main_path' => $nameFolder.'/'.$name_img
            ]);
        }

        Event::where('id', $id)
            ->update([
                'garden_id' => $request->garden_id,
                'name' => $request->name,
                'detail' => $request->detail,
                'slug' => DataOther::slugify($request->name),
                'save_user' => Auth::user()->id
            ]);
        
        return Redirect::to('events');
    }



    /**
     * ลบ กิจกรรม
     */
    public function destroy(Request $request)
    {
        try {
            $id = Crypt::decryptString($request->id);
        } catch (DecryptException $e) {
            return view('errors.404');
        }

        Event::where('id', $id)->delete();

        Picture::where('use_id', $id)->where('picture_type', '4')->delete();

        $nameFolder = 'files/event-'.$id;
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
