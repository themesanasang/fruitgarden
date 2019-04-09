@extends('layouts.app')

@section('script-footer')
    {!! Html::script('https://code.jquery.com/jquery.js') !!}
    
    <script>
        function initMapRsrDetail(){
            var latR = $('#lat-rsr-detail').val();
            var longR = $('#long-rsr-detail').val()

            if(latR > 0 && longR > 0){
            var myLatLng = {lat: parseFloat(latR), lng: parseFloat(longR)};
            
            var map = new google.maps.Map(document.getElementById('map-rsr-detail'), {
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

    {!! Html::script('https://maps.googleapis.com/maps/api/js?key=AIzaSyBFX07vo41AoaQA1BSqALrDdjrTvVwTy4E&callback=initMapRsrDetail') !!}
 
@stop

@section('content')

    <h3>รายละเอียด ร้านอาหาร</h3>
    <hr>

    <div class="uk-child-width-expand@s uk-margin-small-bottom" uk-grid>
        <div class="uk-grid-item-match">
            <dl class="uk-description-list">
                <dt>ชื่อร้านอาหาร :</dt>
                <dd>{{ $rsr->name }}</dd>
                <dt>รายละเอียด :</dt>
                <dd>{{ $rsr->detail }}</dd>
                <dt>ที่อยู่ :</dt>
                <dd>{{ $rsr->address }}</dd>
                <dt>เบอร์โทร :</dt>
                <dd>{{ $rsr->phone }}</dd>
                <dt>พิกัด :</dt>
                <dd>
                    <input type="hidden" id="lat-rsr-detail" value="{{ $lat }}">
                    <input type="hidden" id="long-rsr-detail" value="{{ $long }}">
                    @if($lat > 0 && $long > 0)
                    <div id="map-rsr-detail"></div>
                    @endif
                </dd>
                <dt>รูปหลัก :</dt>
                <dd>
                    @if($rsr->pic_main_name != "")
                    <img class="uk-responsive-width" data-src="{{ asset('public/'.$rsr->pic_main_path) }}" width="360" height="260" alt="" uk-img />
                    @endif
                </dd>
                <dt>วันที่สร้าง :</dt>
                <dd>{{ date("d", strtotime($rsr->created_at)).'-'.date("m", strtotime($rsr->created_at)).'-'.(date("Y", strtotime($rsr->created_at))+543)  }}</dd>
            </dl>
        </div>
    </div>

    <a class="uk-button uk-button-default" href="{{ url('restaurants') }}"><span uk-icon="icon: arrow-left"></span> ย้อนกลับ</a>

@endsection
