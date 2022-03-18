<x-base-layout>
    <div class="mt-6">
        <img src="{{ asset('vaccine-reserve.jpg') }}" class="sec-header">
        <div class="divide"></div>
        <div class="wrap"></div>
        <h1 class="ml-5 text-left text-4xl text-white" style="text-shadow: 2px 2px 8px #000000;">
            @if ($message)
                Diagnose reservation
            @else
                Vaccination reservation
            @endif
        </h1>

        <div class="mx-auto text-center mt-2">
            <p class="inline-block text-center text-xl bg-blue-500 font-bold rounded-full text-white w-8 h-8 pt-1" id="c1">1</p>
            <div class="inline-block mx-3 bg-black w-10 h-1 mb-1 bg-opacity-50" id="l1"></div>
            <p class="inline-block text-center text-xl bg-white  font-bold rounded-full text-blue-500  w-8 h-8 pt-1" id="c2">2</p>
            <div class="inline-block mx-3 bg-black w-10 h-1 mb-1 bg-opacity-50" id="l1"></div>
            <p class="inline-block text-center text-xl bg-white  font-bold rounded-full text-blue-500  w-8 h-8 pt-1" id="c2">✓</p>
        </div>
        <style>
            .text-red-600{
                background-color: cornsilk;
                height: 36px;
                display: inline-block;
                width: 27rem;
                text-align: center;
                transition: cubic-bezier(.57,-0.54,.4,.7);
                border-radius: 8px;
                margin-bottom: 15px;
                padding-top: 7px;
                margin-left: 10.5rem;
                font-size: 18px;
                margin-top: 3rem;

            }
        </style>

        </div>

        @if ($message)
            <div class="font-medium text-red-600">
                <i class="fa-solid fa-circle-exclamation"></i>
                {{ $message }}
            </div>
        @endif

        @if ($errors->any())
            <div>
                <div class="font-medium text-red-600">
                    {{ __('Whoops! Something went wrong.') }}
                </div>

                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <p class="text-black text-center mt-2">Select a location</p>

        <div class="text-center text-xl my-4 mb-2 hidden" id="nearCampaigns">
            Campaigns Near you: 
            <select class="text-md text-black" onchange="selectCampaignOption()">
                <option value="-1">Select a campaign</option>
            </select>
        </div>

        <div id="campaign_selection" class="text-center text-xl my-4 hidden">
            <h3>You have selected: <span class="text-grey">Campaign Name</span></h3>
        </div>

        <div class="mx-auto text-center mt-5">
            <div id="map" class="mt-8 rounded-md border-solid border-4 border-black"
                style="width: 80%; height: 600px; max-height: 90vh; margin: 0 auto;"></div>
            <script src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_maps_api') }}&callback=initMap" defer>
            </script>
            <script>
                var locations = [
                    @foreach ($campaigns as $campaign)
                        ["{{ preg_replace('/\s+/', ' ', trim($campaign->address)) }}", {{ $campaign->location }}, {{ $campaign->id }},
                        "{{ $campaign->start_date }}", "{{ $campaign->status }}"],
                    @endforeach
                ];

                var distances = [];

                function selectCampaignOption() {
                    var val = parseInt(document.querySelector("#nearCampaigns>select").value);
                    
                    if (val != -1) {
                        selectCampaign(locations[val])
                    }
                }

                function selectCampaign(campaign) {
                    document.getElementById('campaign_selection').classList.remove('hidden');
                    document.getElementById('campaign_selection').children[0].children[0].innerHTML = campaign[0];

                    document.getElementById('procceed_button').removeAttribute('disabled');
                    document.getElementById('procceed_form').action = '/reserve/map/' + campaign[3];
                }

                function initMap() {
                    getUserCity();

                    var map = new google.maps.Map(document.getElementById('map'), {
                        mapId: "dcba2c77acce5e73",
                        zoom: 6,
                        center: new google.maps.LatLng(26.8206, 30.8025)
                    });

                    var infowindow = new google.maps.InfoWindow();
                    var marker, i;

                    for (i = 0; i < locations.length; i++) {
                        marker = new google.maps.Marker({
                            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                            map: map,
                            icon: getMarker(locations[i]),
                        });

                        google.maps.event.addListener(marker, 'click', (function(marker, i) {
                            return function() {
                                let content = '<div id="content">' +
                                    '<div id="siteNotice">' +
                                    '</div>' +
                                    '<h1 id="firstHeading" class="firstHeading"><strong>Address:</strong> ' +
                                    locations[i][0] + '</h1>' +
                                    '<div id="bodyContent">' +
                                    '<p><strong>Start date:</strong> ' + locations[i][4] + '</p>' +
                                    '<p><strong>End date:</strong> ' + locations[i][5] + '</p>' +
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
                    var p = 0.017453292519943295;    // Math.PI / 180
                    var c = Math.cos;
                    var a = 0.5 - c((lat2 - lat1) * p)/2 + 
                            c(lat1 * p) * c(lat2 * p) * 
                            (1 - c((lon2 - lon1) * p))/2;

                    return 12742 * Math.asin(Math.sqrt(a)); // 2 * R; R = 6371 km
                }

                function getUserCity() {
                    var geocoder = new google.maps.Geocoder();

                    geocoder.geocode({ 'address': 'Port Said, EG' }, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            var Lat = results[0].geometry.location.lat();
                            var Lng = results[0].geometry.location.lng();
                            
                            
                            for(var i = 0; i < locations.length; i++) {
                                var dist = calculateDistance(Lat, Lng, locations[i][1], locations[i][2]);
                                distances.push({
                                    id: i,
                                    distance: dist,
                                    name: locations[i][0],
                                });
                            }

                            distances.sort(function(a, b) {
                                return a.distance - b.distance;
                            });

                            var select = document.querySelector('#nearCampaigns>select');
                            for(var i = 0; i < distances.length; i++) {
                                // add option in select
                                var option = document.createElement('option');
                                option.value = distances[i].id;
                                option.text = distances[i].name;
                                select.appendChild(option);
                            }

                            document.getElementById('nearCampaigns').classList.remove('hidden');
                        }
                    });
                }
            </script>
        </div>

        <div class="mt-6">
            <div class="mt-3 mx-auto text-right mr-5">
                <form action="/reserve/map/-1" method="POST" id="procceed_form">
                    @csrf
                    <x-button type="submit" disabled id="procceed_button">
                        Procceed
                    </x-button>
                </form>
            </div>
        </div>
    </div>
</x-base-layout>
