@extends('layouts.app')

@section('script-footer')
    {!! Html::script('https://code.jquery.com/jquery.js') !!}
    
    <script>
        function initMapGardenDetail(){
            var latR = $('#lat-garden-detail').val();
            var longR = $('#long-garden-detail').val()

            if(latR > 0 && longR > 0){
            var myLatLng = {lat: parseFloat(latR), lng: parseFloat(longR)};
            
            var map = new google.maps.Map(document.getElementById('map-garden-detail'), {
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

    {!! Html::script('https://maps.googleapis.com/maps/api/js?key=AIzaSyBFX07vo41AoaQA1BSqALrDdjrTvVwTy4E&callback=initMapGardenDetail') !!}
 
@stop

@section('content')

    <h3>รายละเอียด สวนผลไม้</h3>
    <hr>

    <div class="uk-child-width-expand@s uk-margin-small-bottom" uk-grid>
        <div class="uk-grid-item-match">
            <dl class="uk-description-list">
                <dt>ชื่อสวน :</dt>
                <dd>{{ $garden->name }}</dd>
                <dt>รายละเอียด :</dt>
                <dd>{{ $garden->detail }}</dd>
                <dt>ที่อยู่ :</dt>
                <dd>{{ $garden->address }}</dd>
                <dt>เบอร์โทร :</dt>
                <dd>{{ $garden->phone }}</dd>
                <dt>พิกัด :</dt>
                <dd>
                    <input type="hidden" id="lat-garden-detail" value="{{ $lat }}">
                    <input type="hidden" id="long-garden-detail" value="{{ $long }}">
                    @if($lat > 0 && $long > 0)
                    <div id="map-garden-detail"></div>
                    @endif
                </dd>
                <dt>รูปหลัก :</dt>
                <dd>
                    @if($garden->pic_main_name != "")
                    <img class="uk-responsive-width" data-src="../public/{{ $garden->pic_main_path }}/{{ $garden->pic_main_name }}" width="360" height="260" alt="" uk-img />
                    @endif
                </dd>
                <dt>วันที่สร้าง :</dt>
                <dd>{{ date("d", strtotime($garden->created_at)).'-'.date("m", strtotime($garden->created_at)).'-'.(date("Y", strtotime($garden->created_at))+543)  }}</dd>
            </dl>
        </div>
    </div>

    <a class="uk-button uk-button-default" href="{{ url('gardens') }}"><span uk-icon="icon: arrow-left"></span> ย้อนกลับ</a>

@endsection
