<x-app-layout>
    <div class="mt-5 text-center">
        <h1 class="aigps-title">Appointments</h1>
    </div>

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

    <div class="container mt-5p-5 text-dark">
        @foreach ($appointments as $index => $appointment)
            <div class="card rounded my-5 shadow">
                <div class="card-header">
                    Appointment number #{{$appointment->pivot->id}}
                </div>

                <div class="card-body">
                    <h5 class="card-title">Campaign at: {{$appointment->city}} </h5>
                    <p class="card-text">Location: {{ $appointment->address }}</p>
                    <p class="card-text text-muted">Date: {{ $appointment->pivot->date }}</p>
                    <a href="/appointments/{{ $appointment->pivot->id }}/cancel" class="btn btn-outline-danger">Cancel</a>
                    <button data-bs-toggle="modal" data-bs-target="#appointmentModal{{$index}}" class="btn btn-warning">Edit</button>
                </div>
            </div>

            <div class="modal fade" id="appointmentModal{{$index}}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="/appointments/{{$appointment->pivot->id}}/edit" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Appointment</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <p>Select date</p>
                                @csrf
                                <input type="datetime-local" class="form-control" name="date" value="{{ Str::replace('K', 'T', \Carbon\Carbon::parse($appointment->pivot->date)->format('Y-m-dKh:m:s')) }}">
                            </div>

                            <div class="modal-footer text-center">
                                <input type="submit" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        @if (count($appointments) == 0)
            <div class="text-center shadow container bg-white mt-5 rounded p-5 text-dark">
                <h4> You have no appointments right now. </h4>
                <a href="/reserve" class="btn btn-success mt-2">Reserve an appointment</a>
            </div>
        @else
            <div class="my-3 mb-5 text-center">
                <a href="/" class="btn btn-outline-success">Home</a>
                <a href="/reserve" class="btn btn-outline-success">Reserve</a>
            </div>

            <div class="flex">
                <ul class="pagination justify-content-center">
                    @if ($appointments->previousPageUrl())
                        <li class="page-item"><a class="page-link" href="/appointments?page={{ $appointments->currentPage() - 1 }}">Previous</a></li>
                    @endif
                    
                    
                    @for($page = 1; $page <= $appointments->lastPage(); $page++)
                        <li class="page-item"><a class="page-link" href="/appointments?page={{ $page }}">{{ $page }}</a></li>
                    @endfor

                    @if ($appointments->nextPageUrl())
                        <li class="page-item"><a class="page-link" href="/appointments?page={{ $appointments->currentPage() + 1 }}">Next</a></li>
                    @endif
                </ul>
            </div>
        @endif

    </div>
</x-app-layout>