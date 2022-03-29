<x-app-layout>
    <link href="{{asset('css/reservation.css')}}" rel="stylesheet">

    <div class="mt-5 text-center">
        <h1 class="aigps-title">Manage Campaigns</h1>

        @if (session('message'))
            <div class="container alert alert-dark" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <div class="table-responsive text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <h4 class="text-center mb-3"> All Campaigns </h4>
    
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Campaign's start date</th>
                        <th scope="col">Campaign's end date</th>
                        <th scope="col">City</th>
                        <th scope="col">Address</th>
                        <th scope="col">Status</th>
                        <th scope="col">Cancel</th>
                        <th scope="col">Update</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($campaigns as $campaign)
                        <tr>
                            <td>{{ $campaign->start_date }}</td>
                            <td>{{ $campaign->end_date }}</td>
                            <td>{{ $campaign->city }}</td>
                            <td>{{ $campaign->address }}</td>
                            <td>{{ $campaign->status }}</td>
                            <td>
                                <a class="btn btn-outline-danger" href="/staff/moh/manage-campaigns/{{ $campaign->id }}/delete"> Delete </a>
                            </td>

                            <td>
                                <a class="btn btn-outline-primary" href="/staff/moh/manage-campaigns/{{ $campaign->id }}/update"> Update </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex">
                <ul class="pagination justify-content-center">
                    @if ($campaigns->previousPageUrl())
                        <li class="page-item"><a class="page-link" href="/staff/moh/manage-campaigns?page={{ $campaigns->currentPage() - 1 }}">Previous</a></li>
                    @endif
                    
                    
                    @for($page = 1; $page <= $campaigns->lastPage(); $page++)
                        <li class="page-item"><a class="page-link" href="/staff/moh/manage-campaigns?page={{ $page }}">{{ $page }}</a></li>
                    @endfor

                    @if ($campaigns->nextPageUrl())
                        <li class="page-item"><a class="page-link" href="/staff/moh/manage-campaigns?page={{ $campaigns->currentPage() + 1 }}">Next</a></li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <h4 class="mb-3 text-center"> Add a new campaign </h4>    
            <form action="/staff/moh/manage-campaigns/add" method="POST">
                @csrf
                <input id="marker-location" type="hidden" name="location" value="">
                <div class="form-group row">
                    <div class="col-6">
                        <label>Start Date</label>
                        <input type="date" class="form-control" name="start_date" required>
                    </div>

                    <div class="col-6">
                        <label>End Date</label>
                        <input type="date" class="form-control" name="end_date" required>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-6">
                        <label>Capacity</label>
                        <input class="form-control" type="number" min="1" name="capacity_per_day" required>
                    </div>

                    <div class="col-6">
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
                        <input class="form-control" type="text" name="address" required>
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
                    <button type="submit" style="width: 300px;" class="btn btn-success">Add</button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
