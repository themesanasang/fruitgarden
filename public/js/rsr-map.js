function initMap() {

    var lat;
    var lng;
    var position;
    
    var map = new google.maps.Map(document.getElementById('map'), {
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
      
      var map = new google.maps.Map(document.getElementById('map-edit'), {
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