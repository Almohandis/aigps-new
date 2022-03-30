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
    
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">City</th>
                        <th scope="col">Modify Doctors</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hospitals as $hospital)
                        <tr>
                            <td>{{ $hospital->name }}</td>
                            <td>{{ $hospital->city }}</td>
                            <td>
                                <a class="btn btn-outline-primary" href="/staff/moh/manage-doctors/{{$hospital->id}}/doctors"> Modify Doctors </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex">
                <ul class="pagination justify-content-center">
                    @if ($hospitals->previousPageUrl())
                        <li class="page-item"><a class="page-link" href="/staff/moh/manage-doctors/?page={{ $hospitals->currentPage() - 1 }}">Previous</a></li>
                    @endif
                    
                    
                    @for($page = 1; $page <= $hospitals->lastPage(); $page++)
                        <li class="page-item"><a class="page-link" href="/staff/moh/manage-doctors/?page={{ $page }}">{{ $page }}</a></li>
                    @endfor

                    @if ($hospitals->nextPageUrl())
                        <li class="page-item"><a class="page-link" href="/staff/moh/manage-doctors/?page={{ $hospitals->currentPage() + 1 }}">Next</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
