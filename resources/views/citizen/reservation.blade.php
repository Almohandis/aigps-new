<x-app-layout>
    <link href="{{asset('css/reservation.css')}}" rel="stylesheet">


    <div class="mt-5 text-center">
        <h1 class="aigps-title">Vaccination reservation</h1>

        <div class="text-start shadow container bg-white mt-5 rounded p-5 text-dark">
            @if ($message)
                <div class="alert alert-info" role="alert">
                    {{ $message }}
                </div>
            @endif

            @if ($errors->any())
                <div>
                    <div class="alert alert-danger" role="alert">
                        <p>Something went wrong.</p>

                        <ul class="">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <h4> Select a campaign </h4>
            <p class="text-muted">Select a campaign either through the map or through the select options.</p>

            <div class="row">
                <div class="col-12 col-md-6 col-xl-3 visually-hidden" id="nearCampaigns">
                    <p>Near your city</p>
                    <select onchange="selectCampaignOption('nearCampaigns')" class="form-select">
                        <option value="-1">Select a campaign</option>
                    </select>
                </div>

                <div class="col-12 col-md-6 col-xl-3 visually-hidden" id="nearCampaignsUserLocation">
                    <p>Near your location</p>
                    <select onchange="selectCampaignOption('nearCampaignsUserLocation')" class="form-select">
                        <option value="-1">Select a campaign</option>
                    </select>
                </div>

                <div class="col-12 col-md-6 col-xl-3 visually-hidden" id="nearCampaignsUserMarker">
                    <p>Near the marker</p>
                    <select onchange="selectCampaignOption('nearCampaignsUserMarker')" class="form-select">
                        <option value="-1">Select a campaign</option>
                    </select>
                </div>

                <div class="col-12 col-md-6 col-xl-3" id="nearCampaigns2">
                    <p>Based on time</p>
                    <select onchange="selectCampaignOption('nearCampaigns2')" class="form-select">
                        <option value="-1">Select a campaign</option>

                        @foreach ($campaigns as $index => $campaign)
                            <option value="{{ $index }}">{{ $campaign->address }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <div class="alert alert-success mt-5 visually-hidden" role="alert" id="campaign_selection">
                    <p>
                        You have selected: <span class="fw-bold">Campaign Name</span>
                    </p>
                    <p id="distance"> Distance: </p>
                    <p id="start_date"> Starts At: </p>
                    <p id="end_date"> Ends At: </p>
                </div>
            </div>

            <div class="mx-auto text-center mt-5">
                <div id="map" class="aigps-map"></div>

                <script src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_maps_api') }}&callback=initMap" defer></script>

                <script>
                    var locations = [
                        @foreach ($campaigns as $campaign)
                            ["{{ preg_replace('/\s+/', ' ', trim($campaign->address)) }}", {{ $campaign->location }}, {{ $campaign->id }},
                            "{{ $campaign->start_date }}", "{{ $campaign->status }}", "{{ $campaign->end_date }}"],
                        @endforeach
                    ];
                    var distances = [];
                    var distancesUserLocation = [];
                    var distancesUserMarker = [];

                    function selectCampaignOption(id) {
                        var val = parseInt(document.querySelector("#" + id + ">select").value);

                        if (val != -1) {
                            selectCampaign(locations[val])
                        }

                    }

                    function getDistanceByLocation(location) {
                        distances.forEach(function(element, index) {
                            if (location[0] == element.name) {
                                document.getElementById('distance').innerHTML = "Distance: " + element.distance.toFixed(2) + " km";
                                document.getElementById('start_date').innerHTML = "Starts At: " + location[4];
                                document.getElementById('end_date').innerHTML = "Ends At: " + location[6];
                                return;
                            }
                        });
                    }

                    function selectCampaign(campaign) {
                        getDistanceByLocation(campaign);
                        document.getElementById('campaign_selection').classList.remove('visually-hidden');
                        document.getElementById('campaign_selection').children[0].children[0].innerHTML = campaign[0];

                        document.getElementById('procceed_button').removeAttribute('disabled');
                        document.getElementById('procceed_form').action = '/reserve/map/' + campaign[3];
                    }

                    function initMap() {
                        getUserLocation();
                        getUserCity();

                        // let cities = [
                        //     @foreach ($cities as $city)
                        //         {
                        //         name: "{{ $city->city }}",
                        //         center: {
                        //         lat: {{ $city->lat }},
                        //         lng: {{ $city->lng }}
                        //         },

                        //         population: {{ ($city->total * 100) / $max / 100 }}
                        //         },
                        //     @endforeach
                        // ];

                        let markerIcon = {
                            path: "M10.453 14.016l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM12 2.016q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z",
                            fillColor: "red",
                            fillOpacity: 1,
                            strokeWeight: 0,
                            rotation: 0,
                            scale: 2,
                            anchor: new google.maps.Point(15, 30),
                        };

                        var map = new google.maps.Map(document.getElementById('map'), {
                            mapId: "dcba2c77acce5e73",
                            zoom: 6,
                            center: new google.maps.LatLng(26.8206, 30.8025)
                        });

                        const trafficLayer = new google.maps.TrafficLayer();
                        trafficLayer.setMap(map);

                        // cities.forEach(function(city) {
                        //     const cityCircle = new google.maps.Circle({
                        //         strokeColor: "#FF1111",
                        //         strokeOpacity: Math.max(city.population, 0.7) + 0.1,
                        //         strokeWeight: 2,
                        //         fillColor: "#FF0000",
                        //         fillOpacity: Math.max(0.09, Math.min(city.population, 0.5)),
                        //         map,
                        //         center: city.center,
                        //         radius: 30000,
                        //     });
                        // });

                        var infowindow = new google.maps.InfoWindow();
                        var marker, i;

                        let userMarker = new google.maps.Marker({
                            position: map.getCenter(),
                            map: map,
                            icon: markerIcon,
                            draggable: true,
                        });

                        map.addListener('center_changed', () => {
                            userMarker.setPosition(map.getCenter());
                            getUserMarkerLocation(userMarker.getPosition().lat(), userMarker.getPosition().lng());
                        });

                        userMarker.addListener('dragend', () => {
                            getUserMarkerLocation(userMarker.getPosition().lat(), userMarker.getPosition().lng());
                        });

                        for (i = 0; i < locations.length; i++) {
                            marker = new google.maps.Marker({
                                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                                map: map,
                                icon: getMarker(locations[i]),
                            });

                            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                                return function() {
                                    let content = '<div id="content text-start">' +
                                        '<div>' +
                                        '</div>' +
                                        '<h5 class="text-start"><strong>Address:</strong> ' +
                                        locations[i][0] + '</h5>' +
                                        '<div id="bodyContent">' +
                                        '<p class="text-start"><strong>Start date:</strong> ' + locations[i][4] + '</p>' +
                                        '<p class="text-start"><strong>End date:</strong> ' + locations[i][6] + '</p>' +
                                        '</div>' +
                                        '</div>';
                                    infowindow.setContent(content);
                                    infowindow.open(map, marker);
                                    selectCampaign(locations[i]);
                                }
                            })(marker, i));
                        }
                    }

                    function getMarker(location) {
                        const blackMarker = {
                            path: "M10.453 14.016l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM12 2.016q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z",
                            fillColor: "black",
                            fillOpacity: 0.7,
                            strokeWeight: 0,
                            rotation: 0,
                            scale: 2,
                            anchor: new google.maps.Point(15, 30),
                        };


                        const greenMarker = {
                            path: "M10.453 14.016l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM12 2.016q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z",
                            fillColor: "green",
                            fillOpacity: 0.7,
                            strokeWeight: 0,
                            rotation: 0,
                            scale: 2,
                            anchor: new google.maps.Point(15, 30),
                        };

                        const redMarker = {
                            path: "M10.453 14.016l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM12 2.016q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z",
                            fillColor: "red",
                            fillOpacity: 0.7,
                            strokeWeight: 0,
                            rotation: 0,
                            scale: 2,
                            anchor: new google.maps.Point(15, 30),
                        };

                        if (location[5] == 'active') {
                            return greenMarker;
                        }

                        return redMarker;
                    }

                    function calculateDistance(lat1, lon1, lat2, lon2) {
                        var p = 0.017453292519943295; // Math.PI / 180
                        var c = Math.cos;
                        var a = 0.5 - c((lat2 - lat1) * p) / 2 +
                            c(lat1 * p) * c(lat2 * p) *
                            (1 - c((lon2 - lon1) * p)) / 2;

                        return 12742 * Math.asin(Math.sqrt(a)); // 2 * R; R = 6371 km
                    }

                    function getUserCity() {
                        var geocoder = new google.maps.Geocoder();

                        geocoder.geocode({
                            'address': 'Port Said, EG'
                        }, function(results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                var Lat = results[0].geometry.location.lat();
                                var Lng = results[0].geometry.location.lng();

                                distances = sortLocations(Lat, Lng);

                                var select = document.querySelector('#nearCampaigns>select');
                                for (var i = 0; i < distances.length; i++) {
                                    // add option in select
                                    var option = document.createElement('option');
                                    option.value = distances[i].id;
                                    option.text = distances[i].name;
                                    select.appendChild(option);
                                }

                                document.getElementById('nearCampaigns').classList.remove('visually-hidden');
                            }
                        });
                    }

                    function sortLocations(lat, lng) {
                        var result = [];

                        for (var i = 0; i < locations.length; i++) {
                            var dist = calculateDistance(lat, lng, locations[i][1], locations[i][2]);
                            result.push({
                                id: i,
                                distance: dist,
                                name: locations[i][0],
                            });
                        }


                        result.sort(function(a, b) {
                            return a.distance - b.distance;
                        });

                        return result;
                    }

                    function getUserLocation() {
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition((position) => {
                                var userLocation = {
                                    lat: position.coords.latitude,
                                    lng: position.coords.longitude,
                                };

                                distancesUserLocation = sortLocations(userLocation.lat, userLocation.lng);

                                var select = document.querySelector('#nearCampaignsUserLocation>select');
                                for (var i = 0; i < distancesUserLocation.length; i++) {
                                    // add option in select
                                    var option = document.createElement('option');
                                    option.value = distancesUserLocation[i].id;
                                    option.text = distancesUserLocation[i].name;
                                    select.appendChild(option);
                                }

                                document.getElementById('nearCampaignsUserLocation').classList.remove('visually-hidden');
                            });
                        }
                    }

                    function getUserMarkerLocation(lat, lng) {
                        distancesUserMarker = sortLocations(lat, lng);

                        var select = document.querySelector('#nearCampaignsUserMarker>select');

                        // remove all options from select
                        while (select.children[1]) {
                            select.removeChild(select.children[1]);
                        }

                        for (var i = 0; i < distancesUserMarker.length; i++) {
                            // add option in select
                            var option = document.createElement('option');
                            option.value = distancesUserMarker[i].id;
                            option.text = distancesUserMarker[i].name;
                            select.appendChild(option);
                        }

                        document.getElementById('nearCampaignsUserMarker').classList.remove('visually-hidden');
                    }
                </script>
            </div>

            <form action="/reserve/map/-1" method="POST" id="procceed_form" class="text-end">
                @csrf
                <button class="btn btn-success mt-5" type="submit" disabled id="procceed_button">
                    Procceed
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
