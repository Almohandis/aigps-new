<x-app-layout>
    <link href="{{asset('css/reservation.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">


    <div class="mt-5 text-center">
        <h1 class="aigps-title">Manage Campaigns</h1>

        <div class="table-responsive text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <h4 class="text-center mb-3"> All Campaigns </h4>
            
            @if (session('message'))
                <div class="container alert alert-dark" role="alert">
                    {{ session('message') }}
                </div>
            @endif

            <x-help-modal></x-help-modal>
            @if ($errors->any())
                <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                <script>
                    Swal.fire({
                        icon: 'error',
                        title: '{{implode(', ', $errors->all())}}',
                        showConfirmButton: true
                    })
                </script>
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

            @if (session('success'))
                <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                <script>
                    Swal.fire({
                        icon: 'success',
                        title: '{{ session('success') }}',
                        showConfirmButton: false,
                        timer: 2500
                    })
                </script>

                <div class="container alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="accordion mb-4" id="campaignsAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne">
                            Filters & search
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                        data-bs-parent="#campaignsAccordion">
                        <div class="accordion-body">
                            <form method="GET" class="row">
                                <div class="form-group mb-2">
                                    <label class="">Search</label>
                                    <input type="text" name="search" class="form-control" placeholder="Search by address" value="{{ request()->search }}">
                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-3 mt-2">
                                    <label for="sort" class="">Sort by</label>
                                    <div>
                                        <select class="form-control" name="sort" onchange="ChangeSort(this)">
                                            <option value="">Select Sorting</option>
                                            <option value="address">Address</option>
                                            <option value="status">status</option>
                                            <option value="start_date">Start Date</option>
                                            <option value="end_date">End Date</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-3 mt-2">
                                    <label class="">Sort Order</label>
                                    <div class="">
                                        <select class="form-control" name="order">
                                            <option value="asc">Ascending</option>
                                            <option value="desc">Descending</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-3 mt-2">
                                    <label for="city" class="">City</label>
                                    <div class="">
                                        <select class="form-control" name="city">
                                            <option value="">All Cities</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->name }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-3 mt-2">
                                    <label for="status" class="">Status</label>
                                    <div class="">
                                        <select class="form-control" name="status">
                                            <option value="">All Statuses</option>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group mt-4 text-center">
                                    Sort by campaign start and end date
                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-3 mt-2">
                                    <label for="status" class="">From</label>
                                    <div class="">
                                        <input type="date" name="start_date" class="form-control" placeholder="From">
                                    </div>
                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-3 mt-2">
                                    <label for="status" class="">To</label>
                                    <div class="">
                                        <input type="date" name="end_date" class="form-control" placeholder="To">
                                    </div>
                                </div>

                                <div class="form-group row justify-content-center mt-4 mb-4">
                                    <div class="row justify-content-center mt-2">
                                        <button style="width: 250px" type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>

                                <script>
                                    function ChangeSort(input) {
                                        if (input.value == 'start_date' || input.value == 'end_date') {

                                        } else {

                                        }
                                    }
                                </script>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    
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
                        <th scope="col">Clerks</th>
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
                            <td>
                                <button data-bs-toggle="modal" data-bs-target="#addClerk{{$campaign->id}}" class="btn btn-outline-success"> Edit Clerks </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="addClerk{{$campaign->id}}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addClerk{{$campaign->id}}Label">Edit Clerks</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    
                                    <form action="/staff/moh/manage-campaigns/{{ $campaign->id }}/doctors/add" method="POST">
                                        <div class="modal-body">
                                            @csrf
                                            <input placeholder="Clerk National Id" type="text" class="form-control" name="national_id" required autofocus>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <input type="submit" name="remove" class="btn btn-danger" value="Remove Clerk" />
                                            <input type="submit" name="add" class="btn btn-success" value="Add Clerk" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
            
            <div>
                {{ $campaigns->links() }}
            </div>
        </div>

        <div class="text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <h4 class="mb-3 text-center"> Add a new campaign </h4>    
            <form action="/staff/moh/manage-campaigns/add" method="POST">
                @csrf
                <input id="marker-location" type="hidden" name="location" value="">
                <div class="form-group row">
                    <div class="col-12 col-md-6">
                        <label>Start Date</label>
                        <input type="date" class="form-control" name="start_date" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label>End Date</label>
                        <input type="date" class="form-control" name="end_date" required>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12 col-md-6">
                        <label>Capacity</label>
                        <input class="form-control" type="number" min="1" name="capacity_per_day" required>
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
                    <div class="col-12 col-md-6">
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
