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

            <x-help-modal></x-help-modal>
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

            <h4 style="display: inline;"> Select a campaign </h4>
            <!-- Modal and button -->
            <button type="button" class="btn btn-outline-info" data-bs-toggle="modal"
                data-bs-target="#exampleModal"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path
                        d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z" />
                </svg> Help</button>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true" style="top: 100px;" data-backdrop="static" data-keyboard="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="16" height="16" fill="currentColor" class="bi bi-question-circle"
                                    viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                    <path
                                        d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z" />
                                </svg> &nbsp; How to reserve a vaccination appointment ?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="height: 300px; overflow:scroll;">
                            <p><b>You can do the following steps:</b></p>
                            1. First, allow your browser to know your current location to display the nearest campaign.
                            <br>
                            2. If you don't want the nearest campaign you can click on list of campaigns and click on
                            "sort by" button and choose from the displayed options.
                            <br>
                            3. Choose a campaign from what you see suitable.
                            <br>
                            4. Make sure you choose an active campaign so you can proceed.
                            <br>
                            5. Map legend shows if the campaign is active or not and its availability.
                            <br>
                            6. After Proceeding your appointment will appear in the appointments page.
                            <br>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

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
                <div id="legend">
                    <h5>Legend</h5>
                </div>

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
                            document.getElementById('distance').innerHTML = 'Distance from your location: ' + campaign.distanceUser
                                .toFixed(2) + ' km';
                        } else {
                            document.getElementById('distance').innerHTML = 'Distance from your location: Location not available';
                        }
                        document.getElementById('distanceCity').innerHTML = "Distance from your city: " + campaign.distanceCity.toFixed(
                            2) + " km";
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
                            content += '<p class="text-start"><strong>Distance from your location:</strong> ' + campaign.distanceUser
                                .toFixed(2) + ' km' +
                                '</p>';
                        }
                        content += '<p class="text-start"><strong>Distance from your city:</strong> ' + campaign.distanceCity.toFixed(
                            2) + ' km' +
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

                        const orangeMarker = {
                            path: "M10.453 14.016l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM12 2.016q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z",
                            fillColor: "orange",
                            fillOpacity: 0.7,
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
                                icon: getCampaignMarker(locations[i]),
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
                            },
                            user: {
                                name: "User Location",
                                icon: getMarker('red'),
                            },
                            finished: {
                                name: "Finished Campaigns",
                                icon: getMarker('orange'),
                            },
                            notstarted: {
                                name: "Not started Campaigns",
                                icon: getMarker('blue'),
                            }
                        };

                        const legend = document.getElementById("legend");

                        for (const key in icons) {
                            const type = icons[key];
                            const name = type.name;
                            const icon = type.icon;
                            const div = document.createElement("div");
                            div.className = "text-start";

                            div.innerHTML = '<svg fill-opacity="0.7" fill="' + icon.fillColor +
                                '" width="32" height="32"><path strokeWeight="' + icon.strokeWeight + '"  d="' + icon.path +
                                '"></path></svg>' + name;
                            legend.appendChild(div);
                        }

                        map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(legend);

                        getUserLocation();

                    }

                    function getCampaignMarker(camp) {
                        if (new Date(camp.start_date) > new Date()) {
                            return getMarker('blue');
                        }

                        if (new Date(camp.end_date) < new Date()) {
                            return getMarker('orange');
                        }

                        return getMarker('green');;
                    }

                    function getMarker(color) {
                        const baseMarker = {
                            path: "M10.453 14.016l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM12 2.016q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z",
                            fillColor: "green",
                            fillOpacity: 0.7,
                            strokeWeight: 0,
                            rotation: 0,
                            scale: 2,
                            anchor: new google.maps.Point(15, 30),
                        };

                        baseMarker.fillColor = color;

                        return baseMarker;
                    }

                    function setLocations() {
                        if (userLocation) {
                            userHasLocation = true;
                        }
                        calculateDistances();
                    }

                    function getUserLocation() {
                        navigator.geolocation.getCurrentPosition(
                            function(position) {
                                userLocation = {
                                    lat: position.coords.latitude,
                                    lng: position.coords.longitude,
                                }
                                setLocations();
                            },
                            function(error) {
                                return
                            }, {
                                enableHighAccuracy: true,
                                timeout: 5000,
                                maximumAge: 0,
                            }
                        );
                    }

                    function calculateDistances() {
                        for (let i = 0; i < locations.length; i++) {
                            locations[i].distanceUser = userHasLocation ? distance(locations[i].lat, locations[i].lng, userLocation.lat,
                                userLocation.lng) : null;
                            locations[i].distanceCity = cityLocation ? distance(locations[i].lat, locations[i].lng, cityLocation.lat,
                                cityLocation.lng) : null;
                        }

                        generateCampaignsList('start_date', true, true);
                    }

                    function distance(lat1, lon1, lat2, lon2, unit = 'K') {
                        if ((lat1 == lat2) && (lon1 == lon2)) {
                            return 0;
                        } else {
                            var radlat1 = Math.PI * lat1 / 180;
                            var radlat2 = Math.PI * lat2 / 180;
                            var theta = lon1 - lon2;
                            var radtheta = Math.PI * theta / 180;
                            var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(
                                radtheta);
                            if (dist > 1) {
                                dist = 1;
                            }
                            dist = Math.acos(dist);
                            dist = dist * 180 / Math.PI;
                            dist = dist * 60 * 1.1515;
                            if (unit == "K") {
                                dist = dist * 1.609344
                            }
                            if (unit == "N") {
                                dist = dist * 0.8684
                            }
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
                        } else {
                            generateCampaignsList('start_date', true, true);
                        }
                    }

                    function generateCampaignsList(sortby, ascending, date = false) {
                        const campaignsList = document.getElementById('campaigns-list');
                        campaignsList.innerHTML = '';

                        let array = JSON.parse(JSON.stringify(locations));
                        if (date) {
                            array.sort(function(a, b) {
                                return ascending ? new Date(a[sortby]) - new Date(b[sortby]) : new Date(b[sortby]) - new Date(a[
                                    sortby]);
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
                            copy.querySelector('.campaign-capacity').innerHTML = array[i].capacity + ' reservations out of ' + array[i]
                                .maxCapacity;
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
