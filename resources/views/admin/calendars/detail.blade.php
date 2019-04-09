@extends('layouts.app')

@section('content')

    <h3>รายละเอียด ปฏิทิน กิจกรรม</h3>
    <hr>

    <div class="uk-child-width-expand@s uk-margin-small-bottom" uk-grid>
        <div class="uk-grid-item-match">
            <dl class="uk-description-list">
                <dt>ชื่อกิจกรรม :</dt>
                <dd>{{ $calendar->title }}</dd>
                <dt>วันที่เริ่ม(ว-ด-ป) :</dt>
                <dd>{{ date("d", strtotime($calendar->start_date)).'-'.date("m", strtotime($calendar->start_date)).'-'.(date("Y", strtotime($calendar->start_date))+543)  }}</dd>
                <dt>วันที่สิ้นสุด(ว-ด-ป) :</dt>
                <dd>{{ date("d", strtotime($calendar->end_date)).'-'.date("m", strtotime($calendar->end_date)).'-'.(date("Y", strtotime($calendar->end_date))+543)  }}</dd>
                <dt>วันที่สร้าง :</dt>
                <dd>{{ date("d", strtotime($calendar->created_at)).'-'.date("m", strtotime($calendar->created_at)).'-'.(date("Y", strtotime($calendar->created_at))+543)  }}</dd>
            </dl>
        </div>
    </div>

    <a class="uk-button uk-button-default" href="{{ url('calendars') }}"><span uk-icon="icon: arrow-left"></span> ย้อนกลับ</a>

@endsection
