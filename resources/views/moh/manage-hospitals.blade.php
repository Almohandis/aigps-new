<x-app-layout>
    <link href="{{asset('css/reservation.css')}}" rel="stylesheet">

    <div class="mt-5 text-center">
        <h1 class="aigps-title">Manage Hospitals</h1>

        @if (session('message'))
            <div class="container alert alert-dark" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <div class="table-responsive text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <h4 class="text-center mb-3"> All Hospitals </h4>
    
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">City</th>
                        <th scope="col">Total capacity</th>
                        <th scope="col">Update</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hospitals as $hospital)
                        <tr>
                            <td>{{ $hospital->name }}</td>
                            <td>{{ $hospital->city }}</td>
                            <td>{{ $hospital->capacity }}</td>
                            <td>
                                <a class="btn btn-outline-primary" href="/staff/moh/manage-hospitals/{{$hospital->id}}/update"> Update </a>
                            </td>
                            <td>
                                <a class="btn btn-outline-danger" href="/staff/moh/manage-hospitals/{{$hospital->id}}/delete"> Delete </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex">
                <ul class="pagination justify-content-center">
                    @if ($hospitals->previousPageUrl())
                        <li class="page-item"><a class="page-link" href="/staff/moh/manage-hospitals/?page={{ $hospitals->currentPage() - 1 }}">Previous</a></li>
                    @endif
                    
                    
                    @for($page = 1; $page <= $hospitals->lastPage(); $page++)
                        <li class="page-item"><a class="page-link" href="/staff/moh/manage-hospitals/?page={{ $page }}">{{ $page }}</a></li>
                    @endfor

                    @if ($hospitals->nextPageUrl())
                        <li class="page-item"><a class="page-link" href="/staff/moh/manage-hospitals/?page={{ $hospitals->currentPage() + 1 }}">Next</a></li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <h4 class="mb-3 text-center"> Add a new Hospital </h4>    
            <form action="/staff/moh/manage-hospitals/add" method="POST">
                @csrf
                <div class="form-group row">
                    <div class="col-12 col-md-6">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label>Is Isolation</label>
                        <br>
                        <input class="form-check-input" type="checkbox" name="is_isolation" checked>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12 col-md-6">
                        <label>Capacity</label>
                        <input class="form-control" type="number" min="1" name="capacity" required>
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

                <div class="container text-center my-3">
                    <button type="submit" style="width: 300px;" class="btn btn-success">Add</button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
