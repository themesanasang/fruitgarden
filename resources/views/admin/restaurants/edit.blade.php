@extends('layouts.app')

@section('script-footer')
    {!! Html::script('https://code.jquery.com/jquery.js') !!}
    <script>
        function initMapEdit() {
  
            var lat;
            var lng;
            var position;

            lat = $('#lat-rsr-edit').val();
            lng = $('#long-rsr-edit').val();

            if(lat == ''){
                lat = 14.993209;
            }

            if(lng == ''){
                lng = 103.104404;
            }
            

            var myLatLng = {lat: parseFloat(lat), lng: parseFloat(lng)};
            
            var map = new google.maps.Map(document.getElementById('map-rsr-edit'), {
                center: {lat: parseFloat(lat), lng: parseFloat(lng)},
                zoom: 17,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                disableDefaultUI: false,
                zoomControl : true,
            });

            if( $('#lat-rsr-edit').val() != '' || $('#long-rsr-edit').val() != ''){
                var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: ''
                });
            }

            var drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.MARKER,
                drawingControl: true,
                drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: ['marker']
                },
                markerOptions: {
                icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',
                editable: true,
                draggable: true
                },
            });
            drawingManager.setMap(map);
            
            google.maps.event.addListener(drawingManager, 'markercomplete', function(marker) {
                position = marker.getPosition().toUrlValue(6);  
                google.maps.event.addListener(marker, 'position_changed', function () {
                    position = marker.getPosition().toUrlValue(6);  
                    $('#latlon').val(position);
                });

                $('#latlon').val(position);

                if (marker.type != google.maps.drawing.OverlayType.MARKER) {
                    drawingManager.setMap(null);
                }   
            });

            }
    </script>
    {!! Html::script('https://maps.googleapis.com/maps/api/js?key=AIzaSyBFX07vo41AoaQA1BSqALrDdjrTvVwTy4E&libraries=drawing&callback=initMapEdit') !!}
@stop

@section('content')
<h3>แก้ไขข้อมูล ร้านอาหาร</h3>
<hr>

{!! Form::open( array('route' => ['restaurants.update', Crypt::encryptString($rsr['id'])], 'enctype' => 'multipart/form-data', 'class' => 'uk-form-horizontal uk-margin-small uk-grid', 'method' => 'PATCH') ) !!}
<div class="uk-width-1-1@m">
        <div class="uk-margin">
            <label class="uk-form-label" for="name">ชื่อร้านอาหาร <span class="uk-text-danger">*</span></label>
            <div class="uk-form-controls">
                <input class="uk-input" id="name" type="text" name="name" value="{{ $rsr->name }}" disabled>
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="detail">รายละเอียด</label>
            <div class="uk-form-controls">
                <textarea id="detail" name="detail" class="uk-textarea" rows="5" placeholder="รายละเอียด" >{{ $rsr->detail }}</textarea>
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="address">ที่อยู่</label>
            <div class="uk-form-controls">
                <textarea id="address" name="address" class="uk-textarea" rows="4" placeholder="ที่อยู่" >{{ $rsr->address }}</textarea>
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="phone">เบอร์โทรศัพท์</label>
            <div class="uk-form-controls">
                <input class="uk-input" id="phone" type="text" name="phone" placeholder="เบอร์โทรศัพท์" value="{{ $rsr->phone }}">
            </div>
        </div>  
        <div class="uk-margin">
            <label class="uk-form-label" for="latlon">พิกัดร้าน</label>
            <div class="uk-form-controls">
                <input type="hidden" id="lat-rsr-edit" value="{{ $lat }}">
                <input type="hidden" id="long-rsr-edit" value="{{ $long }}">

                <div id="map-rsr-edit"></div>
                <input id="latlon" name="latlon" type="text" class="uk-input" placeholder="พิกัดร้าน" value="{{ $rsr->latlong }}">
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="pic_main">รูปหลัก</label>
            <div class="uk-form-controls">
                <label>เลือกรูปภาพ:</label>
                <small class="form-text text-muted">ไฟล์ JPG,GIF,PNG ขนาดต่ำกว่า 1Mb</small>
                <input type="file" name="mainImageFile" id="mainImageFile">
                @if($rsr->pic_main_name != "")
                    <img class="uk-responsive-width" data-src="{{ asset('public/'.$rsr->pic_main_path) }}" width="360" height="260" alt="" uk-img />
                @endif
            </div>
        </div>

    </div>

    <div class="uk-margin-medium-top uk-width-1-1@m">
        <div class="uk-text-center">
            <button type="submit" class="uk-button uk-button-primary">บันทึก</button>
        </div>
    </div>
{!! Form::close() !!}<!-- form -->

<a class="uk-button uk-button-default" href="{{ url('restaurants') }}"><span uk-icon="icon: arrow-left"></span> ย้อนกลับ</a>

@endsection