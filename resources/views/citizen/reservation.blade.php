<x-app-layout>
    <link href="{{ asset('css/reservation.css') }}" rel="stylesheet">


    <div class="mt-5 text-center">
        <h1 class="aigps-title">
            {{ $diagnosed ? 'Vaccine' : 'Diagnose' }} reservation
        </h1>

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

            <div class="accordion mb-4" id="campaignsAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne">
                            List of campaigns
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                        data-bs-parent="#campaignsAccordion">
                        <div class="accordion-body">
                            <div class="ms-1 row mb-3">
                                <div class="col-12 col-md-2">
                                    <p class="mt-2">Sort By</p>
                                </div>

                                <div class="col-12 col-md-10">
                                    <select class="form-select" onchange="sortCampaigns(this)">
                                        <option value="0">Ascending start date</option>
                                        <option value="1">Descending start date</option>
                                        <option value="2">Near your city</option>
                                        <option value="3">Near your marker</option>
                                        <option value="4">Near your location</option>
                                    </select>
                                </div>
                            </div>


                            <div class="m-0 mb-3 card visually-hidden" id="campaignCopy">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="fw-bold mb-0 campaign-number">Campaign Number </h6>

                                        <button class="btn btn-primary campaign-select">
                                            Select
                                        </button>
                                    </div>

                                    <small class="mb-2 text-muted campaign-city">Location in</small>

                                    <div class="row mt-3">
                                        <div class="col-12 col-md-6">
                                            <h6 class="card-subtitle">Start Date</h6>
                                            <p class="card-text text-muted campaign-start"></p>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <h6 class="card-subtitle">End Date</h6>
                                            <p class="card-text text-muted campaign-end"></p>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <strong>Address: </strong>
                                        <span class="text-muted campaign-address"></span>
                                    </div>


                                </div>
                            </div>

                            <div id="campaigns-list">
                            </div>
                        </div>
                    </div>
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

                <script src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_maps_api') }}&callback=initMap" defer>
                </script>

                <script>
                    var locations = [
                        @foreach ($campaigns as $campaign)
                            {
                            lat: [{{ $campaign->location }}][0],
                            lng: [{{ $campaign->location }}][1],
                            city: '{{ $campaign->city }}',
                            address: '{{ preg_replace('/\s+/', ' ', trim($campaign->address)) }}',
                            start_date: '{{ $campaign->start_date }}',
                            end_date: '{{ $campaign->end_date }}',
                            status: '{{ $campaign->status }}',
                            id: {{ $campaign->id }}
                            },
                        @endforeach
                    ];

                    var locationsDescTime = [];
                    var locationsMarker = [];
                    var locationsCity = [];
                    var locationsUserLocation = [];

                    var userLocationAvailable = false;

                    var distances = [];

                    function getDistanceByLocation(location) {
                        distances.forEach(function(element, index) {
                            if (location[0] == element.name) {
                                document.getElementById('distance').innerHTML = "Distance: " + element.distance.toFixed(2) +
                                    " km";
                                document.getElementById('start_date').innerHTML = "Starts At: " + location[4];
                                document.getElementById('end_date').innerHTML = "Ends At: " + location[6];
                                return;
                            }
                        });
                    }

                    function selectCampaign(campaign) {
                        document.getElementById('campaign_selection').classList.remove('visually-hidden');
                        document.getElementById('campaign_selection').children[0].children[0].innerHTML = campaign.address;

                        document.getElementById('distance').innerHTML = "Distance: " + campaign.distance.toFixed(2) + " km";
                        document.getElementById('start_date').innerHTML = "Starts At: " + campaign.start_date;
                        document.getElementById('end_date').innerHTML = "Ends At: " + campaign.end_date;

                        document.getElementById('procceed_button').removeAttribute('disabled');
                        document.getElementById('procceed_form').action = '/reserve/map/' + campaign.id;
                    }

                    function getUserDescTime() {
                        locationsDescTime = JSON.parse(JSON.stringify(locations)).reverse();
                    }

                    function initMap() {
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

                        var infowindow = new google.maps.InfoWindow();
                        var marker, i;

                        let userMarker = new google.maps.Marker({
                            position: map.getCenter(),
                            map: map,
                            icon: markerIcon,
                            draggable: true,
                        });

                        getUserMarkerLocation(userMarker.getPosition().lat(), userMarker.getPosition().lng());

                        map.addListener('center_changed', () => {
                            userMarker.setPosition(map.getCenter());
                            getUserMarkerLocation(userMarker.getPosition().lat(), userMarker.getPosition().lng());
                        });

                        userMarker.addListener('dragend', () => {
                            getUserMarkerLocation(userMarker.getPosition().lat(), userMarker.getPosition().lng());
                        });

                        for (i = 0; i < locations.length; i++) {
                            marker = new google.maps.Marker({
                                position: new google.maps.LatLng(locations[i].lat, locations[i].lng),
                                map: map,
                                icon: getMarker(locations[i]),
                            });

                            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                                return function() {
                                    let content = '<div id="content text-start">' +
                                        '<div>' +
                                        '</div>' +
                                        '<h5 class="text-start"><strong>Address:</strong> ' +
                                        locations[i].address + '</h5>' +
                                        '<div id="bodyContent">' +
                                        '<p class="text-start"><strong>Start date:</strong> ' + locations[i]
                                        .start_date + '</p>' +
                                        '<p class="text-start"><strong>End date:</strong> ' + locations[i].end_date +
                                        '</p>' +
                                        '</div>' +
                                        '</div>';
                                    infowindow.setContent(content);
                                    infowindow.open(map, marker);
                                    selectCampaign(locations[i]);
                                }
                            })(marker, i));
                        }

                        getUserLocation();
                        getUserCity();
                        getUserDescTime();

                        sortCampaigns({
                            value: 0
                        });
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

                        return greenMarker;
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
                            'address': "{{ Auth::user()->city }}"
                        }, function(results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                var Lat = results[0].geometry.location.lat();
                                var Lng = results[0].geometry.location.lng();

                                let distancesSorted = sortLocations(Lat, Lng);

                                for (i = 0; i < distancesSorted.length; i++) {
                                    locationsCity[i] = distancesSorted[i].location;
                                    locationsCity[i].distance = distancesSorted[i].distance;
                                }
                            }
                        });
                    }

                    function sortLocations(lat, lng) {
                        var result = [];
                        distances = [];

                        for (var i = 0; i < locations.length; i++) {
                            var dist = calculateDistance(lat, lng, locations[i].lat, locations[i].lng);
                            result.push({
                                id: i,
                                distance: dist,
                                name: locations[i].address,
                                location: locations[i]
                            });
                        }


                        result.sort(function(a, b) {
                            return a.distance - b.distance;
                        });

                        for (var i = 0; i < result.length; i++) {
                            distances.push(result[i].distance);
                        }

                        return result;
                    }

                    function getUserLocation() {
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition((position) => {
                                var userLocation = {
                                    lat: position.coords.latitude,
                                    lng: position.coords.longitude,
                                };

                                let distancesSorted = sortLocations(userLocation.lat, userLocation.lng);

                                for (i = 0; i < distancesSorted.length; i++) {
                                    locationsUserLocation[i] = distancesSorted[i].location;
                                    locationsUserLocation[i].distance = distancesSorted[i].distance;
                                }

                                userLocationAvailable = true;
                            });
                        }
                    }

                    function getUserMarkerLocation(lat, lng) {
                        let distancesSorted = sortLocations(lat, lng);

                        for (i = 0; i < distancesSorted.length; i++) {
                            locationsMarker[i] = distancesSorted[i].location;
                            locationsMarker[i].distance = distancesSorted[i].distance;
                        }
                    }

                    function sortCampaigns(input) {
                        if (input.value == 1) {
                            generateCampaignsList(locationsDescTime, true);
                        } else if (input.value == 2) {
                            generateCampaignsList(locationsCity);
                        } else if (input.value == 3) {
                            generateCampaignsList(locationsMarker);
                        } else if (input.value == 4) {
                            generateCampaignsList(locationsUserLocation);
                        } else {
                            generateCampaignsList(locations, true);
                        }
                    }

                    function generateCampaignsList(array, time = false) {
                        const campaignsList = document.getElementById('campaigns-list');

                        campaignsList.innerHTML = '';

                        for (let i = 0; i < array.length; i++) {
                            let copy = document.getElementById('campaignCopy').cloneNode(true);
                            copy.classList.remove('visually-hidden');

                            copy.querySelector('.campaign-number').innerHTML = 'Campaign Number #' + array[i].id;
                            copy.querySelector('.campaign-city').innerHTML = 'Located at ' + array[i].city;
                            copy.querySelector('.campaign-address').innerHTML = array[i].address;
                            copy.querySelector('.campaign-start').innerHTML = array[i].start_date;
                            copy.querySelector('.campaign-end').innerHTML = array[i].end_date;
                            copy.querySelector('.campaign-select').onclick = function() {
                                selectCampaign(array[i]);
                            }

                            // copy.querySelector('.campaign-distance').innerHTML = dis.toFixed(2) + ' km';


                            // add copy to list
                            campaignsList.appendChild(copy);
                        }
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
