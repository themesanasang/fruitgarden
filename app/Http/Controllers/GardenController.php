<?php

namespace App\Http\Controllers;

use App\Garden;
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



    public function index()
    {
        if(request()->ajax()) {
            return Datatables()
            ->of(Garden::query())
            ->addColumn('action', function ($gardens) {
                    return '
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



    public function create()
    {
        return view('admin/gardens/create');
    }



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
            'save_user' => Auth::user()->id
        ])->id;

        /* === image === */
        $nameFolder = 'garden-'.$id;
        $path = "../../garden-images/".$nameFolder;

        if( !is_dir( "../../garden-images/".$nameFolder ) ) {
            File::makeDirectory($path, 0777, true);
        } 

        $image = $request->file('mainImageFile');
        $name_img = time().$image->getClientOriginalName();
        $image->move($path,$name_img);

        Garden::where('id', $id)
            ->update([
                'pic_main_name' => $name_img,
                'pic_main_path' => $nameFolder
            ]);

        /* === end image === */

        return redirect('gardens');
    }



}
