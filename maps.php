<!DOCTYPE html>
<html>
  <head>
    <title>Geolocation</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="icon" href="images/bus-stop-icon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
  <?php
    // require_once("checkpermission.php");
    //add menu on the top of this insert form
    include "menu.php";

    //the aim of this part is to generate HNO automatically, 
    //using year and number of person registered in that year
    date_default_timezone_set('Asia/Bangkok'); //ตั้งค่าโซนเวลา
    include "dbconnect.php";
    $sql = "SELECT * FROM bus_stop";
    $result = $conn->query($sql);
    // $row = $result->fetch_assoc();
    // $n = $row['np']; 
    // $hno = "HN".date("Y").($n+1);
    // $conn->close();
?>
    <div id="map"></div>
    <script>
      // Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.
      var map, infoWindow;
      // function initMap() {
      //   map = new google.maps.Map(document.getElementById('map'), {
      //     center: {lat: 7.1756003999999995, lng: 101.235835},
      //     zoom: 17
      //   });
      //   infoWindow = new google.maps.InfoWindow;

      //   // Try HTML5 geolocation.
      //   if (navigator.geolocation) {
      //     navigator.geolocation.getCurrentPosition(function(position) {
      //       var pos = {
      //         lat: position.coords.latitude,
      //         lng: position.coords.longitude
      //       };

      //       infoWindow.setPosition(pos);
      //       infoWindow.setContent('Location found.');
      //       infoWindow.open(map);
      //       map.setCenter(pos);
      //     }, function() {
      //       handleLocationError(true, infoWindow, map.getCenter());
      //     });
      //   } else {
      //     // Browser doesn't support Geolocation
      //     handleLocationError(false, infoWindow, map.getCenter());
      //   }
      // }

     
  function initMap() {
	  var mapOptions = {
	    center: {lat: 6.882325, lng: 101.236949}, 
	    zoom: 17,
	  }
		
  	var maps = new google.maps.Map(document.getElementById("map"),mapOptions);
	
	  // var marker1 = new google.maps.Marker({
	  //   position: new google.maps.LatLng(13.847616, 100.604736),
	  //   map: maps,
	  //   title: 'ถนน ลาดปลาเค้า',
	  //   icon: 'images/bus-stop-icon.png',
	  // });

    // var marker2 = new google.maps.Marker({
    //   position: new google.maps.LatLng(13.847077, 100.606973),
    //   map: maps,
    //   title: 'หมู่บ้านอารียา',
    //   icon: 'images/bus-stop-icon.png',
    // });

    var busstop1 = new google.maps.Marker({
      position: new google.maps.LatLng(6.8770, 101.2394),
      map: maps,
      title: 'หอ 10',
      icon: 'images/bus-stop-iconnn.png',
    });

    var busstop2 = new google.maps.Marker({
      position: new google.maps.LatLng(6.8780, 101.2388),
      map: maps,
      title: 'ลานประดู่',
      icon: 'images/bus-stop-iconnn.png',
    });

    var busstop3 = new google.maps.Marker({
      position: new google.maps.LatLng(6.8793, 101.2367),
      map: maps,
      title: 'หอสมุดเก่า',
      icon: 'images/bus-stop-iconnn.png',
    });

    var busstop4 = new google.maps.Marker({
      position: new google.maps.LatLng(6.8798, 101.2379),
      map: maps,
      title: 'คลอง 200',
      icon: 'images/bus-stop-iconnn.png',
    });

    var busstop5 = new google.maps.Marker({
      position: new google.maps.LatLng(6.8816, 101.2384),
      map: maps,
      title: 'ศิลปกรรม',
      icon: 'images/bus-stop-iconnn.png',
    });

    var busstop6 = new google.maps.Marker({
      position: new google.maps.LatLng(6.8809, 101.2374),
      map: maps,
      title: 'อาคาร 19',
      icon: 'images/bus-stop-iconnn.png',
    });

    var busstop7 = new google.maps.Marker({
      position: new google.maps.LatLng(6.8813, 101.2372),
      map: maps,
      title: 'ลานเล',
      icon: 'images/bus-stop-iconnn.png',
    });

    var busstop8 = new google.maps.Marker({
      position: new google.maps.LatLng(6.8857, 101.2418),
      map: maps,
      title: 'หอสหกรณ์',
      icon: 'images/bus-stop-iconnn.png',
    });

    var busstop9 = new google.maps.Marker({
      position: new google.maps.LatLng(6.8845, 101.2401),
      map: maps,
      title: 'รัฐศาสตร์',
      icon: 'images/bus-stop-iconnn.png',
    });

    var busstop10 = new google.maps.Marker({
      position: new google.maps.LatLng(6.8836, 101.2386),
      map: maps,
      title: 'วอศ.',
      icon: 'images/bus-stop-iconnn.png',
    });

    var busstop11 = new google.maps.Marker({
      position: new google.maps.LatLng(6.8828, 101.2380),
      map: maps,
      title: 'สาธิตอิสลาม',
      icon: 'images/bus-stop-iconnn.png',
    });

    var busstop12 = new google.maps.Marker({
      position: new google.maps.LatLng(6.8822, 101.2368),
      map: maps,
      title: 'วทท',
      icon: 'images/bus-stop-iconnn.png',
    });

    var busstop13 = new google.maps.Marker({
      position: new google.maps.LatLng(6.8816, 101.2384),
      map: maps,
      title: 'อาคาร 58',
      icon: 'images/bus-stop-iconnn.png',
    });

    var busstop14 = new google.maps.Marker({
      position: new google.maps.LatLng(6.8802, 101.2368),
      map: maps,
      title: 'หอสมุดใหม่',
      icon: 'images/bus-stop-iconnn.png',
    });

    var busstop15 = new google.maps.Marker({
      position: new google.maps.LatLng(6.8790, 101.2365),
      map: maps,
      title: 'สนอ. ใหม่',
      icon: 'images/bus-stop-iconnn.png',
    });

    var busstop16 = new google.maps.Marker({
      position: new google.maps.LatLng(6.8777, 101.2368),
      map: maps,
      title: 'สนอ. เก่า',
      icon: 'images/bus-stop-iconnn.png',
    });

    var busstop17 = new google.maps.Marker({
      position: new google.maps.LatLng(6.8777, 101.2376),
      map: maps,
      title: 'กองกิจ',
      icon: 'images/bus-stop-iconnn.png',
    });
  }


      // function getbusstop() {
      //   map = new google.maps.Map(document.getElementById('map'), {
      //     center: {lat: 7.1756003999999995, lng: 101.235835},
      //     zoom: 17
      //   });
      //   infoWindow = new google.maps.InfoWindow;

      //   // Try HTML5 geolocation.
      //   if (navigator.geolocation) {
      //     navigator.geolocation.getCurrentPosition(function(position) {
      //       var pos = {
      //         lat: position.coords.latitude,
      //         lng: position.coords.longitude
      //       };

      //       infoWindow.setPosition(pos);
      //       infoWindow.setContent('Location found.');
      //       infoWindow.open(map);
      //       map.setCenter(pos);
      //     }, function() {
      //       handleLocationError(true, infoWindow, map.getCenter());
      //     });
      //   } else {
      //     // Browser doesn't support Geolocation
      //     handleLocationError(false, infoWindow, map.getCenter());
      //   }
      // }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD17YvaJEgevt9tHKIoU5ZPqKUlCLBhxM8&callback=initMap">
    </script>
  </body>
</html>