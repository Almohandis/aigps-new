<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="pt-8 sm:pt-0">
            <h1 class="text-center text-9xl text-white" style="text-shadow: 2px 2px 8px #000000;">AIGPS</h1>
            <p class="text-center text-white">
                The new AI system 
                that is used as a tool
                to support the fight 
                against any
                viral pandemic. 
            </p>

            <div class="text-center mt-9">
                <a href="#" class="mx-auto mt-8 text-center bg-blue-500 text-white text-lg font-semibold px-4 py-2 rounded-lg shadow-lg hover:bg-blue-400">
                    Reserve Vaccination
                </a>
            </div>

        </div>
    </div>

    

            <!-- Test -->
            <div id="map" class="mt-8" style="width: 1000px; height: 1000px;"></div>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAy1yWlBZ1kT0587NeF8tM5zM2XTMC2O94&callback=initMap" defer></script>
            <script>
                function initMap() {
                    var locations = [
                    ['Bondi Beach', -33.890542, 151.274856, 4],
                    ['Coogee Beach', -33.923036, 151.259052, 5],
                    ['Cronulla Beach', -34.028249, 151.157507, 3],
                    ['Manly Beach', -33.80010128657071, 151.28747820854187, 2],
                    ['Maroubra Beach', -33.950198, 151.259302, 1]
                    ];
                    
                    var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 10,
                    center: new google.maps.LatLng(-33.92, 151.25)
                    });
                    
                    var infowindow = new google.maps.InfoWindow();

                    var marker, i;
                    
                    for (i = 0; i < locations.length; i++) {  
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                        map: map
                    });
                    
                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                        infowindow.setContent(locations[i][0]);
                        infowindow.open(map, marker);
                        }
                    })(marker, i));
                    }
                }
            </script>
</x-app-layout>