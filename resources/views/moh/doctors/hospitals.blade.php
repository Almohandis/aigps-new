<x-app-layout>
    <link href="{{asset('css/reservation.css')}}" rel="stylesheet">

    <div class="mt-5 text-center">
        <h1 class="aigps-title">Manage Hospital Doctors</h1>

        @if (session('message'))
            <div class="container alert alert-dark" role="alert">
                {{ session('message') }}
            </div>
        @endif

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

        <div class="table-responsive text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <h4 class="text-center mb-3"> All Hospitals </h4>

            <form method="GET" class="row">
                <div class="form-group col-12 col-md-6 col-lg-3">
                    <label for="sort" class="">Sort by</label>
                    <div>
                        <select class="form-control" name="sort">
                            <option value="">Select Sorting</option>
                            <option value="name">Name</option>
                            <option value="capacity">capacity</option>
                            <option value="is_isolation">Isolation</option>
                        </select>
                    </div>
                </div>

                <div class="form-group col-12 col-md-6 col-lg-3">
                    <label class="">Sort Order</label>
                    <div class="">
                        <select class="form-control" name="order">
                            <option value="asc">Ascending</option>
                            <option value="desc">Descending</option>
                        </select>
                    </div>
                </div>

                <div class="form-group col-12 col-md-6 col-lg-3">
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

                <div class="form-group col-12 col-md-6 col-lg-3">
                    <label for="status" class="">Isolation State</label>
                    <div class="">
                        <select class="form-control" name="is_isolation">
                            <option value="">All</option>
                            <option value="is_isolation">Isolation</option>
                            <option value="inactive">Non-Isolation</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row justify-content-center mt-2 mb-4">
                    <div class="row">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">City</th>
                        <th scope="col">Is Isolation</th>
                        <th scope="col">Total capacity</th>
                        <th scope="col">Modify Doctors</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hospitals as $hospital)
                        <tr>
                            <td>{{ $hospital->name }}</td>
                            <td>{{ $hospital->city }}</td>
                            <td>{{ $hospital->is_isolation ? 'Yes' : 'No' }}</td>
                            <td>{{ $hospital->capacity }}</td>
    
                            <td>
                                <a class="btn btn-outline-primary" href="/staff/moh/manage-doctors/{{$hospital->id}}/doctors"> Modify Doctors </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div>
                {{ $hospitals->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
