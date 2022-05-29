<x-app-layout>
    <style>
        #submit-btn {
            display: none;
        }

        #red {
            width: 10px;
            height: 10px;
            background: red;
            border-radius: 50%;
            display: inline-block;
            margin-right: 10px;
        }

        #black {
            width: 10px;
            height: 10px;
            background: black;
            border-radius: 50%;
            display: inline-block;
            margin-right: 10px;
        }

        #green {
            width: 10px;
            height: 10px;
            background: green;
            border-radius: 50%;
            display: inline-block;
            margin-right: 10px;
        }

        .inline-block {
            display: inline-block;
        }

        #legend {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            margin-right: 10px;
            margin-left: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 5px black;
            padding: 5px;
        }

    </style>
    <div class="table-responsive text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
        <form action="/print" method="POST">
            @csrf
            <input type="hidden" name="table" id="table">
            <input type="hidden" name="title" id="title">
            <button type="submit" id="print-btn" class="btn btn-primary">Download as PDF</button>
        </form>
        <form id="form" action="/stats" method="POST" class="row">
            @csrf
            <div class="col-12 col-md-4 mt-3">
                <select name="report_name" id="report-name" class="form-control">
                    <option disabled hidden selected>Please choose a report name</option>
                    @foreach ($names as $name)
                        <option value="{{ $name }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-4 mt-3">
                <select name="report_by" id="report-by" class="form-control"></select>
            </div>
            <div id="submit-btn" class="col-12 col-md-4 mt-3 row">
                <div>
                    <button type="submit" id="generate-btn" class="btn btn-primary">Generate report</button>
                </div>
            </div>
        </form>
        @if (isset($data_by_city))
            <h1>{{ $report_title }}</h1>
            <h4>Date: {{ date('M d, Y') }}</h4>
            <h4>Time: {{ date('h:i A') }}</h4>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>City</th>
                        <th>Number of campaigns</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_by_city as $city)
                        <tr>
                            <td>{{ $city->city }}</td>
                            <td>{{ $city->total_campaigns }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif (isset($campaigns))
            <h1>{{ $report_title }}</h1>
            <h4>Date: {{ date('M d, Y') }}</h4>
            <h4>Time: {{ date('h:i A') }}</h4>
            @php $i = 1; @endphp
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Start date</th>
                        <th>End date</th>
                        <th>City</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($campaigns as $campaign)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $campaign->start_date }}</td>
                            <td>{{ $campaign->end_date }}</td>
                            <td>{{ $campaign->city }}</td>
                            <td>{{ $campaign->address }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <div id="map" class="mt-8 rounded-md border-solid border-4 border-black"
            style="width: 100%; height: 600px; max-height: 90vh; margin: 0px auto; position: relative; overflow: hidden;">
        </div>
        <script src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_maps_api') }}&callback=initMap" defer>
        </script>
        <script>
            function initMap() {

                var locations = [
                    @foreach ($campaigns as $campaign)
                        ["{{ preg_replace('/\s+/', ' ', trim($campaign->address)) }}", {{ $campaign->location }},
                            {{ $campaign->id }},
                            "{{ $campaign->start_date }}", "{{ $campaign->end_date }}"
                        ],
                    @endforeach
                ];


                var map = new google.maps.Map(document.getElementById('map'), {
                    mapId: "dcba2c77acce5e73",
                    zoom: 6,
                    center: new google.maps.LatLng(26.8206, 30.8025)
                });

                // create map legend
                let legend_div = document.createElement('div');
                legend_div.id = 'legend';
                let black_div = document.createElement('div');
                let green_div = document.createElement('div');
                let red_div = document.createElement('div');
                let black_color = document.createElement('div');
                black_color.setAttribute('id', 'black');
                let green_color = document.createElement('div');
                green_color.setAttribute('id', 'green');
                let red_color = document.createElement('div');
                red_color.setAttribute('id', 'red');
                let black_text = document.createElement('p');
                black_text.innerHTML = 'Upcoming campaigns';
                black_text.classList.add('inline-block');
                let green_text = document.createElement('p');
                green_text.innerHTML = 'Active campaigns';
                green_text.classList.add('inline-block');
                let red_text = document.createElement('p');
                red_text.innerHTML = 'Expired campaigns';
                red_text.classList.add('inline-block');
                black_div.appendChild(black_color);
                black_div.appendChild(black_text);
                green_div.appendChild(green_color);
                green_div.appendChild(green_text);
                red_div.appendChild(red_color);
                red_div.appendChild(red_text);
                legend_div.appendChild(black_div);
                legend_div.appendChild(green_div);
                legend_div.appendChild(red_div);
                map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(legend_div);



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
                            let content = '<div style="text-align:center" id="content">' +
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
                let date = new Date();
                let start_date = new Date(location[4]);
                let end_date = new Date(location[5]);
                if (start_date > date) {
                    return blackMarker;
                } else if (start_date <= date && end_date > date) {
                    return greenMarker;
                } else {
                    return redMarker;
                }
            }
        </script>
    </div>
    <script src="{{ asset('js/statistics.js') }}"></script>
</x-app-layout>
