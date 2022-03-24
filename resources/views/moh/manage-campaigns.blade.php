<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
        <div class="pt-8 sm:pt-0">
            <h1 class="add-hero2">All upcoming campaigns</h1><br>
            <form action="/staff/moh/manage-campaigns/add" id="procceed_form" method="POST">
                @csrf
                <input id="marker-location" type="hidden" name="location" value="">
                <div class="tbl-header">
                    <table>
                        <tr>
                            <th>#</th>
                            <th>Campaign's start date</th>
                            <th>Campaign's end date</th>
                            <th>City</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Cancel</th>
                        </tr>
                    </table>
                </div>
                <div class="tbl-content">
                    <table>
                        @php $i = 1 @endphp
                        @foreach ($campaigns as $campaign)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $campaign->start_date }}</td>
                                <td>{{ $campaign->end_date }}</td>
                                <td>{{ $campaign->city }}</td>
                                <td>{{ $campaign->address }}</td>
                                <td>{{ $campaign->status }}</td>
                                <td><a class="text-red-500" href="/staff/moh/manage-campaigns/{{$campaign->id}}/cancel"> Cancel </a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <br>
                <div class="add-campaign">
                    <h2 class="add-hero">Add new campaign</h2>
                    <div class="mt-4">
                        <label for="start_date" style="margin-left: 3rem;">Start date</label>
                        <input type="date" name="start_date" style="border-color: gray;border-width: 1px;" required>
                        <label for="end_date" style="margin-left: 16rem;">End date</label>
                        <input type="date" name="end_date" style="border-color: gray;border-width: 1px;" required><br>
                        <div style="margin-left: 3rem;margin-top: 2rem;">
                            <label for="capacity">Capacity per day</label>
                            <input type="number" min="1" name="capacity_per_day" id="capacity"
                                style="border-color: gray;border-width: 1px;"><br>
                        </div>
                        <div>
                            <label for="city">City</label>
                            <input type="text" name="city" id="city" placeholder="Campaign city" style="border-color: gray;border-width: 1px;"
                                required><br>
                        </div>
                        <div style="  margin-top: -1.5rem;margin-left: 20rem;">
                            <label id="addressLabel" for="address" style="margin-left: 6rem;">Address</label>
                            <input type="text" name="address" id="address" style="margin-left: 0rem;height: 2.3rem;"
                                required><input type="button" id="search-button" value="Search"
                                class="update-btn5"><br>
                        </div>
                        <div style="margin-top: 2rem;margin-left: 3rem;">
                            <label for="Doctors">Doctors</label>
                            <input type="button" id="doctor-add-button" value="Add doctor" class="add-doc-btn">
                        </div>
                    </div>

                </div>
                <h3 class="add-hero">Choose a location on the map</h3>
                {{-- !! --}}
                <div class="mx-auto text-center mt-5">
                    <div id="map" class="mt-8 rounded-md border-solid border-4 border-black"
                        style="width: 119%; height: 600px; max-height: 90vh; margin: 0px auto; position: relative; overflow: hidden;margin-left: -6rem;""></div>
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
                                    mapId: "dcba2c77acce5e73",
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

                    <div class="      mt-6" style="margin-right: -8rem;">
                        <div class="mt-3 mx-auto text-right mr-5">
                            <x-button type="submit" id="procceed_button" style="margin-bottom: 1rem;">
                                Procceed
                            </x-button>
                        </div>
                    </div>
                    {{-- !! --}}

            </form>
        </div>
    </div>
    <script src="{{ asset('js/manage-campaigns.js') }}"></script>
</x-app-layout>
