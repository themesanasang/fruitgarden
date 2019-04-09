@extends('layouts.app')

@section('content')

    <h3>รายละเอียด กิจกรรม</h3>
    <hr>

    <div class="uk-child-width-expand@s uk-margin-small-bottom" uk-grid>
        <div class="uk-grid-item-match">
            <dl class="uk-description-list">
                <dt>ชื่อสวนผลไม้ :</dt>
                <dd>{{ $event->garden_name }}</dd>
                <dt>ชื่อกิจกรรม :</dt>
                <dd>{{ $event->name }}</dd>
                <dt>รายละเอียด :</dt>
                <dd>{{ $event->detail }}</dd>
                <dt>รูปหลัก :</dt>
                <dd>
                    @if($event->pic_main_name != "")
                    <img class="uk-responsive-width" data-src="{{ asset('public/'.$event->pic_main_path) }}" height="260" alt="" uk-img />
                    @endif
                </dd>
                <dt>วันที่สร้าง :</dt>
                <dd>{{ date("d", strtotime($event->created_at)).'-'.date("m", strtotime($event->created_at)).'-'.(date("Y", strtotime($event->created_at))+543)  }}</dd>
            </dl>
        </div>
    </div>

    <a class="uk-button uk-button-default" href="{{ url('events') }}"><span uk-icon="icon: arrow-left"></span> ย้อนกลับ</a>

@endsection
