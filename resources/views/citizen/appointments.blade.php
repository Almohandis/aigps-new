<x-app-layout>
    <div class="mt-5 text-center">
        <h1 class="aigps-title">Appointments</h1>
    </div>

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
                <!-- Modal and button -->
            <button type="button" class="btn btn-outline-info" data-bs-toggle="modal"
            data-bs-target="#exampleModal"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path
                    d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z" />
            </svg> Help</button>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                            </svg> &nbsp; What is "My appointments" page ?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="height: 300px; overflow:scroll;">
                        <p><b></b></p>
                        • This page displays the appointments that you have reserved.
                        <br>
                        • You can edit your appointment by clicking "Edit" button.
                        <br>
                        • You can Cancel your appointments by clicking "Cancel" button.
                        <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
                
                <a href="/reserve" class="btn btn-success mt-2">Reserve an appointment</a>
            </div>
        @else
            <div class="my-3 mb-5 text-center">
                <a href="/" class="btn btn-dark">Home</a>
                <a href="/reserve" class="btn btn-dark">Reserve</a>
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