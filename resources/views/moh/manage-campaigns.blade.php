<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
        <div class="pt-8 sm:pt-0">
            <h1>All upcoming campaigns</h1><br>
            <form action="/staff/moh/manage-campaigns/add" id="procceed_form" method="POST">
                @csrf
                <input id="marker-location" type="hidden" name="location" value="">
                <table>
                    <tr>
                    <th>#</th>
                    <th>Campaign's start date</th>
                    <th>Campaign's end date</th>
                    <th>Type</th>
                    <th>Address</th>
                    <th>Status</th>
                    </tr>
                    {{ $i = 1 }}
                    @foreach ($campaigns as $campaign)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $campaign->start_date }}</td>
                            <td>{{ $campaign->end_date }}</td>
                            <td>{{ $campaign->type }}</td>
                            <td>{{ $campaign->address }}</td>
                            <td>{{ $campaign->status }}</td>
                        </tr>
                    @endforeach
                </table>
                <br>
                <h2>Add new campaign</h2>
                <div class="mt-4">
                    <label for="start_date">Start date</label>
                    <input type="datetime-local" name="start_date" required><br>
                    <label for="end_date">End date</label>
                    <input type="datetime-local" name="end_date" required><br>
                    <label for="type">Type</label>
                    <select name="type" id="type">
                        <option value="" selected hidden disabled>Select campaign type</option>
                        <option value="Vaccination">Vaccination</option>
                        <option value="Sanitization">Sanitization</option>
                    </select><br>
                    <label id="addressLabel" for="address">Address</label>
                    <input type="text" name="address" id="address" required><input type="button" id="search-button"
                        value="Search"><br>
                    <h3>Choose a location on the map</h3>
                    {{-- !! --}}
                    <div class="mx-auto text-center mt-5">
                        <div id="map" class="mt-8 rounded-md border-solid border-4 border-black"
                            style="width: 80%; height: 600px; max-height: 90vh; margin: 0 auto;"></div>
                        <script src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_maps_api') }}&callback=initMap" defer>
                        </script>
                        <script>
                            let marker;
                            let geocoder;
                            let map;

                            document.getElementById('search-button').addEventListener('click', () => {
                                geocode({
                                    address: document.getElementById('address').value
                                });
                            });

                            function initMap() {

                                map = new google.maps.Map(document.getElementById('map'), {
                                    zoom: 6,
                                    center: new google.maps.LatLng(26.8206, 30.8025),
                                    mapTypeControl: false,
                                });

                                var infowindow = new google.maps.InfoWindow();
                                let markerIcon = {
                                    path: "M10.453 14.016l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM12 2.016q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z",
                                    fillColor: "black",
                                    fillOpacity: 0.7,
                                    strokeWeight: 0,
                                    rotation: 0,
                                    scale: 2,
                                    anchor: new google.maps.Point(15, 30),
                                };

                                geocoder = new google.maps.Geocoder();

                                marker = new google.maps.Marker({
                                    position: map.getCenter(),
                                    map: map,
                                    icon: markerIcon,
                                    draggable: true,
                                });

                                map.addListener('center_changed', () => {
                                    marker.setPosition(map.getCenter());
                                    document.getElementById('marker-location').value = marker.getPosition();
                                });

                                marker.addListener('dragend', () => {
                                    document.getElementById('marker-location').value = marker.getPosition();
                                });

                            }

                            function geocode(request) {
                                marker.setMap(null);
                                geocoder
                                    .geocode(request)
                                    .then((result) => {
                                        const {
                                            results
                                        } = result;
                                        map.zoom = 16;
                                        map.setCenter(results[0].geometry.location);
                                        marker.setPosition(results[0].geometry.location);
                                        marker.setMap(map);
                                        return results;
                                    })
                                    .catch((e) => {
                                        alert("Couldn't find the location, please search with another address");
                                    });
                            }
                        </script>
                    </div>

                    <div class="mt-6">
                        <div class="mt-3 mx-auto text-right mr-5">
                            <x-button type="submit" id="procceed_button">
                                Procceed
                            </x-button>
                        </div>
                    </div>
                    {{-- !! --}}
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/manage-campaigns.js') }}"></script>
</x-app-layout>
