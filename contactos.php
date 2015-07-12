<?php include 'header.php'; ?>
<br />
<br />
<br />

<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script>
	
	function initialize() {
  directionsDisplay = new google.maps.DirectionsRenderer();
  var mapOptions = {
    zoom:7,
    center: new google.maps.LatLng(39.7784635096575, -8.15185546875),
  }
  map = new google.maps.Map(document.getElementById('map'), mapOptions);
  directionsDisplay.setMap(map);
}
      function calculateRoute(from, to) {
        var myOptions = {
          zoom: 10,
          center: new google.maps.LatLng(39.7784635096575, -8.15185546875),
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        // Draw the map
        var mapObject = new google.maps.Map(document.getElementById("map"), myOptions);
 
        var directionsService = new google.maps.DirectionsService();
        var directionsRequest = {
          origin: from,
          destination: to,
          travelMode: google.maps.DirectionsTravelMode.DRIVING,
          unitSystem: google.maps.UnitSystem.METRIC
        };
        directionsService.route(
          directionsRequest,
          function(response, status)
          {
            if (status == google.maps.DirectionsStatus.OK)
            {
              new google.maps.DirectionsRenderer({
                map: mapObject,
                directions: response
              });
            }
            else
              $("#error").append("Unable to retrieve your route<br />");
          }
        );
      }
 
      $(document).ready(function() {
        // If the browser supports the Geolocation API
        if (typeof navigator.geolocation == "undefined") {
          $("#error").text("Your browser doesn't support the Geolocation API");
          return;
        }
 
        $("#from-link, #to-link").click(function(event) {
          event.preventDefault();
          var addressId = this.id.substring(0, this.id.indexOf("-"));
 
          navigator.geolocation.getCurrentPosition(function(position) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({
              "location": new google.maps.LatLng(position.coords.latitude, position.coords.longitude)
            },
            function(results, status) {
              if (status == google.maps.GeocoderStatus.OK)
                $("#" + addressId).val(results[0].formatted_address);
              else
                $("#error").append("Unable to retrieve your address<br />");
            });
          },
          function(positionError){
            $("#error").append("Error: " + positionError.message + "<br />");
          },
          {
            enableHighAccuracy: true,
            timeout: 10 * 1000 // 10 seconds
          });
        });
 
        $("#calculate-route").submit(function(event) {
          event.preventDefault();
          calculateRoute($("#from").val(), $("#to").val());
        });
      });
	  
	  google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    <style type="text/css">
      #map {
        width: 500px;
        height: 400px;
        margin-top: 10px;
      }
    </style>
    <p><h3><i>Onde estamos</i></h3></p>
    <form id="calculate-route" name="calculate-route" action="#" method="get">
      <label for="from">De:  </label>
      <input type="text" id="from" name="from" required="required" placeholder="Um endereço" size="30" />
      <a id="from-link" href="#">A minha posição</a>
      <br />
 
 
	 <label for="to">Para:</label> 
	 <select id="to" name="to" style="width:200px" >
      <option value="Universidade de Braga, Campus de Gualtar‎">Uminho Braga</option>
      <option value="Uminho Azurém">Uminho Azurém</option>
    </select>
      <br />

 
      <input type="submit" />
      <input type="reset" />
    </form>
    <div id="map"></div>
    <p id="error"></p>
	
	
	
<p><h3><i>CONTACTOS</i></h3></p>
<br />
<br />
<p>Telefone - 707 206 707</p>
<br />
<br />
<p>CAT: Centro de Atendimento Telefónico da AT - Autoridade Tributária e Aduaneira EFactur-UM</p>
<br />
<p>Dias úteis: 08:30H às 18:30H</p>
<br />
<p>EMAIL:</p> 
              <p>Questões técnico-jurídicas:  e-facturUM@at.efactur-UM.pt</p>
              <p>Questões informáticas:  portal-UM@at.efactur-UM.pt</p>
<br />			  
<?php include 'footer.php'; ?>			  