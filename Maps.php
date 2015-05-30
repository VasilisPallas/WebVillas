<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta charset="utf-8">
        <title>Χάρτης</title>
        <style>
            html, body, #map-canvas {
                height: 95%;
                margin: 0px;
                padding: 0px
            }
        </style>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBzsksClNr1SdvprMZYGY29cPnTv0QodR0"></script>



        <script type="text/javascript">
            var map;
            var myCenter = new google.maps.LatLng(39.641, 22.417);
            var marker;

            function initialize() {
                var mapProp = {
                    center: myCenter,
                    zoom: 6,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };

                var map = new google.maps.Map(document.getElementById("map-canvas"), mapProp);

                marker = new google.maps.Marker({
                    position: myCenter,
                    draggable: true,
                    icon: 'images/pin.png'
                });

                marker.setMap(map);

                google.maps.event.addListener(marker, "drag", function() {
                    document.getElementById("grid").value = marker.position.toUrlValue();
                });
            }

            google.maps.event.addDomListener(window, 'load', initialize);
        </script>




    </head>
    <body>


        <div id="map-canvas"></div>
        <p style=" margin-left:20px;"> Αντιγράψτε τις συντεταγμένες και βάλετε τες στο πεδίο δίπλα από το κουμπί "Πρόσθεσε στον χάρτη"</p>
        <input style="margin-left:20px;" type="text" id="grid"/>
    </body>

</html>
