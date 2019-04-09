<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Calendar;
use App\_helpers\DataOther;
use App\Garden;
use App\Hotel;
use App\Rsr;
use App\Event;
use App\CalendarM;
use App\Contact;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   
    public function index()
    {
        if(Auth::check()){
            return view('admin/home');
        }else{

            $slider = DB::table('f_garden')
                    ->where('star', 1)
                    ->where('pic_main_name', '!=', '')
                    ->select('name', 'pic_main_name', 'pic_main_path', 'slug')
                    ->orderby('id', 'desc')
                    ->limit(3)
                    ->get();


            $garden = DB::table('f_garden')
                    ->select('name', 'pic_main_name', 'pic_main_path', 'slug')
                    ->orderby('id', 'desc')
                    ->limit(3)
                    ->get();

            
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


            $event = DB::table('f_events')
                    ->select('name', 'pic_main_name', 'pic_main_path', 'slug')
                    ->orderby('id', 'desc')
                    ->limit(6)
                    ->get();

            
            $hotel = DB::table('f_hotels')
                    ->select('name', 'pic_main_name', 'pic_main_path', 'slug')
                    ->orderby('id', 'desc')
                    ->limit(4)
                    ->get();

            
            $restaurants = DB::table('f_restaurants')
                    ->select('name', 'pic_main_name', 'pic_main_path', 'slug')
                    ->orderby('id', 'desc')
                    ->limit(10)
                    ->get();

            //return view('pages/home');        
            return view('pages/home', array(
                'slider' => $slider,
                'garden' => $garden,
                'calendar' => $calendar,
                'event' => $event,
                'hotel' => $hotel,
                'restaurants' => $restaurants
            ));
        }
    }

}
