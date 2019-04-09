@extends('layouts.app')

@section('content')

    <h3>รายละเอียด ผู้ใช้งาน</h3>
    <hr>

    <div class="uk-child-width-expand@s uk-margin-small-bottom" uk-grid>
        <div class="uk-grid-item-match">
            <dl class="uk-description-list">
                <dt>ชื่อผู้ใช้งาน :</dt>
                <dd>{{ $user->username }}</dd>
                <dt>ชื่อ-นามสกุล :</dt>
                <dd>{{ $user->fullname }}</dd>
                <dt>อีเมล์ :</dt>
                <dd>{{ $user->email }}</dd>
                <dt>ระดับการใช้งาน :</dt>
                <dd><?php echo (($user->level == 1)?'<span class="uk-text-primary">ผู้ดูแลระบบ</span>':'');  echo (($user->level == 2)?'<span class="uk-text-muted">ทั่วไป</span>':''); ?></dd>
                <dt>สถานะการใช้งาน :</dt>
                <dd><?php echo (($user->status == 'open')?'<span class="uk-text-success">เปิด</span>':'<span class="uk-text-danger">ปิด</span>'); ?></dd>
                <dt>วันที่สร้าง :</dt>
                <dd>{{ date("d", strtotime($user->created_at)).'-'.date("m", strtotime($user->created_at)).'-'.(date("Y", strtotime($user->created_at))+543)  }}</dd>
            </dl>
        </div>
    </div>

    <a class="uk-button uk-button-default" href="{{ url('users') }}"><span uk-icon="icon: arrow-left"></span> ย้อนกลับ</a>

@endsection
