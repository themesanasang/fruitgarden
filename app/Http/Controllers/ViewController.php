<?php

namespace App\Http\Controllers;

use DB;
use App\Garden;
use App\Hotel;
use App\Rsr;
use App\Event;
use App\CalendarM;
use App\Contact;
use App\Picture;
use Illuminate\Http\Request;

class ViewController extends Controller
{



    /**
     * แสดงหน้า สวนผลไม้ ทั้งหมด
     */
    public function view_garden_all()
    {
        $data = Garden::orderby('id', 'desc')->paginate(9);

        return view('pages/page-card', array(
            'type' => 'สวนผลไม้',
            'view_all' => 'view/garden',
            'section_color' => 'uk-section-garden-head',
            'data' => $data,
        ));
    }


    /**
     * แสดงหน้า สวนผลไม้ by slug
     */
    public function view_garden_slug($sulg)
    {
        try {
            $data = Garden::where('slug', $sulg)->select('*')->first();

            if(count((array)$data) == 0){
                return view('errors.404');
            }
        } catch (DecryptException $e) {
            return view('errors.404');
        }

        $lat='0';
        $long='0';
        if($data['latlong'] != ''){
            $ll = explode(',', $data['latlong']);
            $lat = $ll[0];
            $long = $ll[1];
        }

        $pic = Picture::where('use_id', $data['id'])->where('picture_type', '1')->get();

        return view('pages/page-full', array(
            'type' => 'สวนผลไม้',
            'view_all' => 'view/garden',
            'section_color' => 'uk-section-garden-head',
            'data' => $data,
            'lat' => $lat,
            'long' => $long,
            'pic' => $pic
        ));
    }




    /**
     * แสดงหน้า กิจกรรม ทั้งหมด
     */
    public function view_event_all()
    {
        $data = Event::orderby('id', 'desc')->paginate(9);

        return view('pages/page-card', array(
            'type' => 'กิจกรรม',
            'view_all' => 'view/event',
            'section_color' => 'uk-section-event-head',
            'data' => $data,
        ));
    }



    /**
     * แสดงหน้า กิจกรรม by slug
     */
    public function view_event_slug($sulg)
    {
        try {
            $data = Event::where('slug', $sulg)->select('*')->first();

            if(count((array)$data) == 0){
                return view('errors.404');
            }
        } catch (DecryptException $e) {
            return view('errors.404');
        }

        $garden_name = Garden::where('id', $data['garden_id'])->select('name')->first();

        $pic = Picture::where('use_id', $data['id'])->where('picture_type', '4')->get();

        return view('pages/page-full', array(
            'type' => 'กิจกรรม',
            'view_all' => 'view/event',
            'garden_name' => $garden_name['name'],
            'section_color' => 'uk-section-event-head',
            'data' => $data,
            'pic' => $pic
        ));
    }



    /**
     * แสดงหน้า ที่พัก ทั้งหมด
     */
    public function view_hotel_all()
    {
        $data = Hotel::orderby('id', 'desc')->paginate(9);

        return view('pages/page-card', array(
            'type' => 'ที่พัก',
            'view_all' => 'view/hotel',
            'section_color' => 'uk-section-hotel-head',
            'data' => $data,
        ));
    }



    /**
     * แสดงหน้า ที่พัก by slug
     */
    public function view_hotel_slug($sulg)
    {
        try {
            $data = Hotel::where('slug', $sulg)->select('*')->first();

            if(count((array)$data) == 0){
                return view('errors.404');
            }
        } catch (DecryptException $e) {
            return view('errors.404');
        }

        $lat='0';
        $long='0';
        if($data['latlong'] != ''){
            $ll = explode(',', $data['latlong']);
            $lat = $ll[0];
            $long = $ll[1];
        }

        $pic = Picture::where('use_id', $data['id'])->where('picture_type', '2')->get();

        return view('pages/page-full', array(
            'type' => 'ที่พัก',
            'view_all' => 'view/hotel',
            'section_color' => 'uk-section-hotel-head',
            'data' => $data,
            'lat' => $lat,
            'long' => $long,
            'pic' => $pic
        ));
    }



    /**
     * แสดงหน้า ร้านอาหาร ทั้งหมด
     */
    public function view_restaurants_all()
    {
        $data = Rsr::orderby('id', 'desc')->paginate(9);

        return view('pages/page-card', array(
            'type' => 'ร้านอาหาร',
            'view_all' => 'view/restaurants',
            'section_color' => 'uk-section-rsr-head',
            'data' => $data,
        ));
    }



    /**
     * แสดงหน้า ร้านอาหาร by slug
     */
    public function view_restaurants_slug($sulg)
    {
        try {
            $data = Rsr::where('slug', $sulg)->select('*')->first();

            if(count((array)$data) == 0){
                return view('errors.404');
            }
        } catch (DecryptException $e) {
            return view('errors.404');
        }

        $lat='0';
        $long='0';
        if($data['latlong'] != ''){
            $ll = explode(',', $data['latlong']);
            $lat = $ll[0];
            $long = $ll[1];
        }

        $pic = Picture::where('use_id', $data['id'])->where('picture_type', '3')->get();

        return view('pages/page-full', array(
            'type' => 'ร้านอาหาร',
            'view_all' => 'view/restaurants',
            'section_color' => 'uk-section-rsr-head',
            'data' => $data,
            'lat' => $lat,
            'long' => $long,
            'pic' => $pic
        ));
    }



    /**
     * แสดงหน้า หน้าติดต่อ
     */
    public function view_contact()
    {
        $contact = Contact::all();

        return view('pages/contact', array('contact_data' => $contact));
    }

}
