@extends('layouts.app')

@section('script-footer')
    {!! Html::script('https://code.jquery.com/jquery.js') !!}
    <script>
        function initMap() {
            var lat;
            var lng;
            var position;

            var map = new google.maps.Map(document.getElementById('map-garden'), {
            center: {lat: 14.993209, lng: 103.104404},
            zoom: 12,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: false,
            zoomControl : true,
            });

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
                //lat = marker.getPosition().lat();
                //lon = marker.getPosition().lng();

                position = marker.getPosition().toUrlValue(6);  
                google.maps.event.addListener(marker, 'position_changed', function () {
                    position = marker.getPosition().toUrlValue(6);  
                    $('#latlon').val(position);
                });

                $('#latlon').val(position);

                if (marker.type != google.maps.drawing.OverlayType.MARKER) {
                drawingManager.setMap(null);
                }

                //console.log(lat);
                //console.log(lon);    
            });

        }
    </script>
    {!! Html::script('https://maps.googleapis.com/maps/api/js?key=AIzaSyBFX07vo41AoaQA1BSqALrDdjrTvVwTy4E&libraries=drawing&callback=initMap') !!}
@stop

@section('content')

<h3>เพิ่ม สวนผลไม้</h3>
<hr>

{!! Form::open( array('route' => 'gardens.store', 'enctype' => 'multipart/form-data', 'class' => 'uk-form-horizontal uk-margin-small uk-grid') ) !!}
    <div class="uk-width-1-1@m">
        <div class="uk-margin">
            <label class="uk-form-label" for="name">ชื่อสวนผลไม้ <span class="uk-text-danger">*</span></label>
            <div class="uk-form-controls">
                <input class="uk-input {{ $errors->has('name') ? ' uk-form-danger' : '' }}" id="name" type="text" name="name" value="{{ old('name') }}" placeholder="ชื่อสวนผลไม้" required autofocus>
                @if ($errors->has('name'))
                    <div class="uk-text-danger">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="detail"></label>
            <div class="uk-form-controls">
                <label><input class="uk-checkbox" type="checkbox" id="star" name="star" value="1"> แนะนำ</label>
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="detail">รายละเอียด</label>
            <div class="uk-form-controls">
                <textarea id="detail" name="detail" class="uk-textarea" rows="5" placeholder="รายละเอียด" ></textarea>
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="address">ที่อยู่</label>
            <div class="uk-form-controls">
                <textarea id="address" name="address" class="uk-textarea" rows="4" placeholder="ที่อยู่" ></textarea>
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="phone">เบอร์โทรศัพท์</label>
            <div class="uk-form-controls">
                <input class="uk-input" id="phone" type="text" name="phone" placeholder="เบอร์โทรศัพท์">
            </div>
        </div>  
        <div class="uk-margin">
            <label class="uk-form-label" for="latlon">พิกัดร้าน</label>
            <div class="uk-form-controls">
                <div id="map-garden"></div>
                <input id="latlon" name="latlon" type="text" class="uk-input" placeholder="พิกัดร้าน">
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="pic_main">รูปหลัก</label>
            <div class="uk-form-controls">
                <label>เลือกรูปภาพ:</label>
                <small class="form-text text-muted">ไฟล์ JPG,GIF,PNG ขนาดต่ำกว่า 1Mb</small>
                <input type="file" name="mainImageFile" id="mainImageFile">
            </div>
        </div>
    </div>

    <div class="uk-margin-medium-top uk-width-1-1@m">
        <div class="uk-text-center">
            <button type="submit" class="uk-button uk-button-primary">บันทึก</button>
        </div>
    </div>
{!! Form::close() !!}<!-- form -->

<a class="uk-button uk-button-default" href="{{ url('gardens') }}"><span uk-icon="icon: arrow-left"></span> ย้อนกลับ</a>

@endsection