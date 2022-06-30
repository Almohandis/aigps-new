<x-app-layout>
    <link href="{{asset('css/reservation.css')}}" rel="stylesheet">

    <div class="mt-5 text-center">
    <x-help-modal></x-help-modal>
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
            <!-- Modal and button -->
            <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#exampleModal1"
                style="float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path
                        d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z" />
                </svg> Help</button>

            <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                                </svg> &nbsp; How to edit campaign ?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="height: 300px; overflow:scroll;">
                            <p><b>You can do the following steps:</b></p>
                            <b> 1.</b> First, you have the start date of the campaign you can edit it by choosing another date from the calendar.
                            <br>
                            <b>2.</b> Then, you have the end date of the campaign you can edit it by choosing another date from the calendar.
                            <br>
                            <b>3.</b> You can change the maximum capacity of the campaign by changing the value in the textbox.
                            <br>
                            <b>4.</b> Choose the city from the drop-down list, in which the campaign will be.
                            <br>
                            <b>5.</b> If you wish to edit the campaign's address, insert the descriptive address of the campaign in the textbox.
                            <br>
                            <b>6.</b> You can change the location of the campaign, by moving the marker on the map.
                            <br>
                            <b>7.</b> Click "Update" button to proceed with editing the campaign.
                            <br>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
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
                                <option value="{{ $city->name }}">{{ $city->name }}</option>
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
