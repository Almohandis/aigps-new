<x-app-layout>
    <link href="{{ asset('css/reservation.css') }}" rel="stylesheet">


    <div class="mt-5 text-center">
        <h1 class="aigps-title">
            Vaccine reservation
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
                                        <option value="1">Ascending start date</option>
                                        <option value="2">Descending start date</option>
                                        <option value="3">Near your city</option>
                                        <option value="4">Near your location</option>
                                        <option value="5">Capacity Ascending</option>
                                        <option value="6">Capacity Descending</option>
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

                                    <div class="mt-3">
                                        <strong>Capacity: </strong>
                                        <span class="text-muted campaign-capacity"></span>
                                    </div>

                                    <div class="mt-3">
                                        <strong>Distance from your city: </strong>
                                        <span class="text-muted campaign-city-distance"></span>
                                    </div>

                                    <div class="mt-3" id="campaign-user-distance-div">
                                        <strong>Distance from your location: </strong>
                                        <span class="text-muted campaign-user-distance"></span>
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
                    <p id="distanceCity"> Distance: </p>
                    <p id="start_date"> Starts At: </p>
                    <p id="end_date"> Ends At: </p>
                </div>
            </div>

            <div class="mx-auto text-center mt-5">
                <div id="map" class="aigps-map"></div>
                <div id="legend"><h5>Legend</h5></div>

                <script src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_maps_api') }}&callback=initMap" defer>
                </script>

                <script>
                    var locations = [
                        @foreach ($campaigns as $index => $campaign)
                            {
                                index: {{ $index }},
                                lat: [{{ $campaign->location }}][0],
                                lng: [{{ $campaign->location }}][1],
                                city: '{{ $campaign->city }}',
                                address: '{{ preg_replace('/\s+/', ' ', trim($campaign->address)) }}',
                                start_date: '{{ $campaign->start_date }}',
                                end_date: '{{ $campaign->end_date }}',
                                status: '{{ $campaign->status }}',
                                id: {{ $campaign->id }},
                                capacity: {{ $campaign->capacity }},
                                maxCapacity: {{ $campaign->maxCapacity }},
                            },
                        @endforeach
                    ];

                    var map;
                    var markers = [];
                    var infowindow;

                    var distinations = [];
                    var origins = [];
                    let userLocation;
                    let userHasLocation = false;
                    let cityLocation = {
                        lat: {{ Auth::user()->getCity()->lat }},
                        lng: {{ Auth::user()->getCity()->lng }},
                    };

                    function selectCampaign(campaign) {
                        document.getElementById('campaign_selection').classList.remove('visually-hidden');
                        document.getElementById('campaign_selection').children[0].children[0].innerHTML = campaign.address;

                        if (userHasLocation) {
                            document.getElementById('distance').innerHTML = 'Distance from your location: ' + campaign.distanceUser.toFixed(2) + ' km';
                        } else {
                            document.getElementById('distance').innerHTML = 'Distance from your location: Location not available';
                        }
                        document.getElementById('distanceCity').innerHTML = "Distance from your city: " + campaign.distanceCity.toFixed(2) + " km";
                        document.getElementById('start_date').innerHTML = "Starts At: " + campaign.start_date;
                        document.getElementById('end_date').innerHTML = "Ends At: " + campaign.end_date;

                        document.getElementById('procceed_button').removeAttribute('disabled');
                        document.getElementById('procceed_form').action = '/reserve/map/' + campaign.id;
                    }

                    function setMarkerContent(marker, campaign) {
                        let content = '<div id="content text-start">' +
                            '<div>' +
                            '</div>' +
                            '<h5 class="text-start"><strong>Address:</strong> ' +
                            campaign.address + '</h5>' +
                            '<div id="bodyContent">' +
                            '<p class="text-start"><strong>Start date:</strong> ' + campaign
                            .start_date + '</p>' +
                            '<p class="text-start"><strong>End date:</strong> ' + campaign.end_date +
                            '</p>';

                        if (userHasLocation) {
                            content += '<p class="text-start"><strong>Distance from your location:</strong> ' + campaign.distanceUser.toFixed(2) + ' km' +
                            '</p>';
                        }
                        content += '<p class="text-start"><strong>Distance from your city:</strong> ' + campaign.distanceCity.toFixed(2) + ' km' +
                            '</p>' +
                            '</div>' +
                            '</div>';
                        infowindow.setContent(content);
                        infowindow.open(map, marker);
                    }

                    function initMap() {
                        const greenMarker = {
                            path: "M10.453 14.016l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM12 2.016q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z",
                            fillColor: "green",
                            fillOpacity: 0.7,
                            strokeWeight: 0,
                            rotation: 0,
                            scale: 2,
                            anchor: new google.maps.Point(15, 30),
                        };

                        let markerIcon = {
                            path: "M10.453 14.016l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM12 2.016q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z",
                            fillColor: "red",
                            fillOpacity: 1,
                            strokeWeight: 0,
                            rotation: 0,
                            scale: 2,
                            anchor: new google.maps.Point(15, 30),
                        };

                        map = new google.maps.Map(document.getElementById('map'), {
                            mapId: "dcba2c77acce5e73",
                            zoom: 6,
                            center: new google.maps.LatLng(26.8206, 30.8025)
                        });

                        const trafficLayer = new google.maps.TrafficLayer();
                        trafficLayer.setMap(map);

                        infowindow = new google.maps.InfoWindow();
                        var i;

                        for (i = 0; i < locations.length; i++) {
                            markers.push(new google.maps.Marker({
                                position: new google.maps.LatLng(locations[i].lat, locations[i].lng),
                                map: map,
                                icon: greenMarker,
                            }));

                            google.maps.event.addListener(markers[i], 'click', (function(marker, i) {
                                return function() {
                                    // setMarkerContent(markers[i], locations[i]);
                                    selectCampaign(locations[i]);
                                }
                            })(markers[i], i));
                        }

                        const icons = {
                            campaign: {
                                name: "Campaign",
                                icon: greenMarker,
                            }
                        };

                        const legend = document.getElementById("legend");

                        for (const key in icons) {
                            const type = icons[key];
                            const name = type.name;
                            const icon = type.icon;
                            const div = document.createElement("div");
                            div.className = "text-start";

                            div.innerHTML = '<svg fill-opacity="0.7" fill="' + icon.fillColor + '" width="32" height="32"><path strokeWeight="' + icon.strokeWeight + '"  d="' + icon.path + '"></path></svg>' + name;
                            legend.appendChild(div);
                        }

                        map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(legend);

                        getUserLocation();
                        
                    }

                    function setLocations() {
                        if (userLocation) {
                            userHasLocation = true;
                        }
                        calculateDistances();
                    }

                    function getUserLocation() {
                        navigator.geolocation.getCurrentPosition(
                            function (position) {
                                userLocation = {
                                    lat: position.coords.latitude,
                                    lng: position.coords.longitude,
                                }
                                setLocations();
                            },
                            function (error) {
                                return
                            },
                            {
                                enableHighAccuracy: true,
                                timeout: 5000,
                                maximumAge: 0,
                            }
                        );
                    }

                    function calculateDistances() {
                        for(let i = 0; i < locations.length; i++) {
                            locations[i].distanceUser = userHasLocation ? distance(locations[i].lat, locations[i].lng, userLocation.lat, userLocation.lng) : null;
                            locations[i].distanceCity = cityLocation ? distance(locations[i].lat, locations[i].lng, cityLocation.lat, cityLocation.lng) : null;
                        }

                        generateCampaignsList('start_date', true, true);
                    }

                    function distance(lat1, lon1, lat2, lon2, unit='K') {
                        if ((lat1 == lat2) && (lon1 == lon2)) {
                            return 0;
                        }
                        else {
                            var radlat1 = Math.PI * lat1/180;
                            var radlat2 = Math.PI * lat2/180;
                            var theta = lon1-lon2;
                            var radtheta = Math.PI * theta/180;
                            var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
                            if (dist > 1) {
                                dist = 1;
                            }
                            dist = Math.acos(dist);
                            dist = dist * 180/Math.PI;
                            dist = dist * 60 * 1.1515;
                            if (unit=="K") { dist = dist * 1.609344 }
                            if (unit=="N") { dist = dist * 0.8684 }
                            return dist;
                        }
                    }

                    function sortCampaigns(input) {
                        if (input.value == 1) {
                            generateCampaignsList('start_date', true, true);
                        } else if (input.value == 2) {
                            generateCampaignsList('start_date', false, true);
                        } else if (input.value == 3) {
                            generateCampaignsList('distanceCity');
                        } else if (input.value == 4) {
                            generateCampaignsList('distanceUser');
                        } else if (input.value == 5) {
                            generateCampaignsList('capacity', true);
                        } else if (input.value == 6) {
                            generateCampaignsList('capacity', false);
                        }  else {
                            generateCampaignsList('start_date', true, true);
                        }
                    }

                    function generateCampaignsList(sortby, ascending, date=false) {
                        const campaignsList = document.getElementById('campaigns-list');
                        campaignsList.innerHTML = '';

                        let array = JSON.parse(JSON.stringify(locations));
                        if (date) {
                            array.sort(function(a, b) {
                                return ascending ? new Date(a[sortby]) - new Date(b[sortby]) : new Date(b[sortby]) - new Date(a[sortby]);
                            });
                        } else {
                            array.sort(function(a, b) {
                                return ascending ? a[sortby] - b[sortby] : b[sortby] - a[sortby];
                            });
                        }

                        for (let i = 0; i < array.length; i++) {
                            let copy = document.getElementById('campaignCopy').cloneNode(true);
                            copy.classList.remove('visually-hidden');

                            copy.querySelector('.campaign-number').innerHTML = 'Campaign Number #' + array[i].id;
                            copy.querySelector('.campaign-city').innerHTML = 'Located at ' + array[i].city;
                            copy.querySelector('.campaign-address').innerHTML = array[i].address;
                            copy.querySelector('.campaign-start').innerHTML = array[i].start_date;
                            copy.querySelector('.campaign-end').innerHTML = array[i].end_date;
                            copy.querySelector('.campaign-capacity').innerHTML = array[i].capacity + ' reservations out of ' + array[i].maxCapacity;
                            copy.querySelector('.campaign-select').onclick = function() {
                                selectCampaign(array[i]);
                            }

                            if (userHasLocation) {
                                copy.querySelector('.campaign-user-distance').innerHTML = array[i].distanceUser.toFixed(2) + ' km';
                            } else {
                                copy.querySelector('.campaign-user-distance').innerHTML = 'Location not available';
                            }

                            copy.querySelector('.campaign-city-distance').innerHTML = array[i].distanceCity.toFixed(2) + ' km';

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
