<div class="google-map" data-latitude="$Latitude" data-longitude="$Longitude" data-zoom="$MapZoom" data-type="$MapType">
    <% if $Markers %>
    <% loop $Markers %>
    <script class="map-markers" type="text/json">
        [
            {
                "latitude": $Latitude,
                "longitude": $Longitude,
                "title": "$Title",
                "link": <% if $Link %>"$Link.LinkURL"<% else %>false<% end_if %>
            }<% if not $Last %>,<% end_if %>
        ]
    </script>
    <% end_loop %>
    <% end_if %>
</div>
<script>
    function initGoogleMap() {

        var maps = document.getElementsByClassName('google-map');
        var numMaps = maps.length;
        for(var i = 0; i < numMaps; i++) {
            var mapElement = maps[i];
            var markersData = mapElement.querySelector('.map-markers');

            var map = new google.maps.Map(mapElement, {
                center: {
                    lat: parseFloat(mapElement.dataset.latitude),
                    lng: parseFloat(mapElement.dataset.longitude)
                },
                zoom: parseFloat(mapElement.dataset.zoom),
                mapTypeId: mapElement.dataset.type
            });

            if(markersData){
                markersData = JSON.parse(markersData.textContent);
                var numMarkers = markersData.length;
                for(var j = 0; j < numMarkers; j++){
                    var marker = new google.maps.Marker({
                        position: {
                            lat: parseFloat(markersData[j].latitude),
                            lng: parseFloat(markersData[j].longitude)
                        },
                        map: map,
                        title: markersData[j].title,
                        allData: markersData[j]
                    });
                    marker.addListener('click', function(e) {
                        if(this.allData.link){
                            window.location = this.allData.link;
                        }
                    });
                }
            }
        }
    }
    google.maps.event.addDomListener(window, 'load', initGoogleMap);
</script>
