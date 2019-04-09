<?php

namespace App\Http\Controllers;

use App\CalendarM;
use App\_helpers\DataOther;
use Calendar;
use Auth;
use DB;
use Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Facades\Datatables;

class CalendarController extends Controller
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
     * แสดงหน้ารายการ ปฏิทิน
     */
    public function index()
    {
        if(request()->ajax()) {

            $data = DB::table('f_calendars')
            ->select(
                'id'
                , 'title'
                , db::raw('CONCAT(  DATE_FORMAT( start_date , "%d" ), "-", DATE_FORMAT( start_date , "%m" ) , "-", DATE_FORMAT( start_date , "%Y" ) +543 ) AS start_date')
                , db::raw('CONCAT(  DATE_FORMAT( end_date , "%d" ), "-", DATE_FORMAT( end_date , "%m" ) , "-", DATE_FORMAT( end_date , "%Y" ) +543 ) AS end_date'))
            ->get();

            return Datatables()
            ->of($data)
            ->addColumn('action', function ($calendars) {
                    return '
                        <a uk-icon="icon: file-text" uk-tooltip="title: รายละเอียด; pos: top-left" href="' . route('calendars.show', Crypt::encryptString($calendars->id)) .'"></a>
                        <a uk-icon="icon: file-edit" uk-tooltip="title: แก้ไข; pos: top-left" href="' . route('calendars.edit', Crypt::encryptString($calendars->id)) .'"></a>
                        <a uk-icon="icon: trash" uk-tooltip="title: ลบ; pos: top-left" href="javascript:void(0)" onclick="calendarsDelete(\''.Crypt::encryptString($calendars->id).'\')"></a>
                    '; 
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin/calendars/list');
    }



    /**
     * แสดง ปฏิทิน แบบเต็ม
     */
    public function full_calendar()
    {
        $events = [];
        $data = CalendarM::all();

        if($data->count()){

            foreach ($data as $key => $value) {
            $events[] = Calendar::event(
                $value->title,
                true,
                new \DateTime($value->start_date),
                new \DateTime($value->end_date.' +1 day'),
                null,
	                [
	                    'color' => DataOther::random_color(),
	                ]
            );
            }
        }

        $calendar = Calendar::addEvents($events); 

        return view('admin/calendars/calender', compact('calendar'));
    }


    /**
     * แสดงหน้าสร้าง ปฏิทิน
     */
    public function create()
    {
        return view('admin/calendars/create');
    }




    /**
     * เช็คชื่อ ปฏิทิน ห้ามว่าง และ ห้ามซ้ำ
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title' => ['required', 'unique:f_calendars']
        ]);
    }



    /**
     * สร้าง กิจกรรม ปฏิทิน
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $day1 = explode('-', $request->start_date);
        $day1 = $day1[2].'-'.$day1[1].'-'.$day1[0];
        
        $day2 = explode('-', $request->end_date);
        $day2 = $day2[2].'-'.$day2[1].'-'.$day2[0];

        $id = CalendarM::create([
            'title' => $request->title,
            'start_date' => $day1,
            'end_date' => $day2,
            'save_user' => Auth::user()->id
        ])->id;

        return redirect('calendars');
    }



    /**
     * แสดงรายละเอียด กิจกรรม ปฏิทิน
     */
    public function show($id)
    {
        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return view('errors.404');
        }

        $calendar = CalendarM::find($id);

        return view('admin.calendars.detail', array(
            'calendar' => $calendar
        ));
    }



    /**
     * แสดงหน้าแก้ไข กิจกรรม ปฏิทิน
     */
    public function edit($id)
    {
        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return view('errors.404');
        }
        
        $calendar = CalendarM::find($id);

        return view('admin.calendars.edit', array(
            'calendar' => $calendar
        ));
    }



    /**
     * แก้ไข กิจกรรม ปฏิทิน
     */
    public function update(Request $request, $id)
    {
        try {
            $id = Crypt::decryptString($id);        
        } catch (DecryptException $e) {
            return view('errors.404');
        }  
        
        $day1 = explode('-', $request->start_date);
        $day1 = $day1[2].'-'.$day1[1].'-'.$day1[0];
        
        $day2 = explode('-', $request->end_date);
        $day2 = $day2[2].'-'.$day2[1].'-'.$day2[0];

        CalendarM::where('id', $id)
            ->update([
                'title' => $request->title,
                'start_date' => $day1,
                'end_date' => $day2,
                'save_user' => Auth::user()->id
            ]);
        
        return Redirect::to('calendars');
    }



    /**
     * ลบ กิจกรรม ปฏิทิน
     */
    public function destroy(Request $request)
    {
        try {
            $id = Crypt::decryptString($request->id);
        } catch (DecryptException $e) {
            return view('errors.404');
        }

        CalendarM::where('id', $id)->delete();

        return response()->json(['success'=>"ลบข้อมูลเรียบร้อยแล้ว"]);
    }



}
