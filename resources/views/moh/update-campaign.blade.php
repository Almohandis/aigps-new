<x-app-layout>
    <link href="{{asset('css/reservation.css')}}" rel="stylesheet">

    <div class="mt-5 text-center">
        @if ($errors->any())
            <div class="container">
                <div class="alert alert-danger" role="alert">
                    <p>Something went wrong. Please check the form below for errors.</p>

                    <ul class="">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <h4 class="mb-3 text-center"> Update Campaign #{{$campaign->id}} </h4>    
            <form method="POST">
                @csrf
                <input id="marker-location" type="hidden" name="location" value="">
                <div class="form-group row">
                    <div class="col-12 col-md-6">
                        <label>Start Date</label>
                        <input value="{{$campaign->start_date}}" type="date" class="form-control" name="start_date" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label>End Date</label>
                        <input value="{{$campaign->end_date}}" type="date" class="form-control" name="end_date" required>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12 col-md-6">
                        <label>Capacity</label>
                        <input value="{{$campaign->capacity_per_day}}" class="form-control" type="number" min="1" name="capacity_per_day" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label>City</label>
                        <select name="city" class="form-control">
                            @foreach ($cities as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col">
                        <label>Address</label>
                        <input value="{{$campaign->address}}" class="form-control" type="text" name="address" required>
                    </div>
                </div>

                <div class="mt-3">
                    <h5>Select the location of the campaign in the map</h5>
                    <div id="map" class="aigps-map"></div>
                    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_maps_api') }}&callback=initMap" defer></script>
                    <script>
                        let marker;
                        let geocoder;
                        let map;

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

                <div class="container text-center my-3">
                    <button type="submit" style="width: 300px;" class="btn btn-success">Update</button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
