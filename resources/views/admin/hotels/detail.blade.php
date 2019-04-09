@extends('layouts.app')

@section('script-footer')
    {!! Html::script('https://code.jquery.com/jquery.js') !!}
    
    <script>
        function initMapHotelDetail(){
            var latR = $('#lat-hotel-detail').val();
            var longR = $('#long-hotel-detail').val()

            if(latR > 0 && longR > 0){
            var myLatLng = {lat: parseFloat(latR), lng: parseFloat(longR)};
            
            var map = new google.maps.Map(document.getElementById('map-hotel-detail'), {
                zoom: 17,
                center: myLatLng
            });

            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: ''
            });
            } 
        }
    </script> 

    {!! Html::script('https://maps.googleapis.com/maps/api/js?key=AIzaSyBFX07vo41AoaQA1BSqALrDdjrTvVwTy4E&callback=initMapHotelDetail') !!}
 
@stop

@section('content')

    <h3>รายละเอียด ที่พัก</h3>
    <hr>

    <div class="uk-child-width-expand@s uk-margin-small-bottom" uk-grid>
        <div class="uk-grid-item-match">
            <dl class="uk-description-list">
                <dt>ชื่อที่พัก :</dt>
                <dd>{{ $hotel->name }}</dd>
                <dt>รายละเอียด :</dt>
                <dd>{{ $hotel->detail }}</dd>
                <dt>ที่อยู่ :</dt>
                <dd>{{ $hotel->address }}</dd>
                <dt>เบอร์โทร :</dt>
                <dd>{{ $hotel->phone }}</dd>
                <dt>พิกัด :</dt>
                <dd>
                    <input type="hidden" id="lat-hotel-detail" value="{{ $lat }}">
                    <input type="hidden" id="long-hotel-detail" value="{{ $long }}">
                    @if($lat > 0 && $long > 0)
                    <div id="map-hotel-detail"></div>
                    @endif
                </dd>
                <dt>รูปหลัก :</dt>
                <dd>
                    @if($hotel->pic_main_name != "")
                    <img class="uk-responsive-width" data-src="{{ asset('public/'.$hotel->pic_main_path) }}" width="360" height="260" alt="" uk-img />
                    @endif
                </dd>
                <dt>วันที่สร้าง :</dt>
                <dd>{{ date("d", strtotime($hotel->created_at)).'-'.date("m", strtotime($hotel->created_at)).'-'.(date("Y", strtotime($hotel->created_at))+543)  }}</dd>
            </dl>
        </div>
    </div>

    <a class="uk-button uk-button-default" href="{{ url('hotels') }}"><span uk-icon="icon: arrow-left"></span> ย้อนกลับ</a>

@endsection
