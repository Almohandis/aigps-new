<x-app-layout>
    <div class="mt-5 text-center">
        <h1 class="aigps-title">Appointments</h1>
    </div>

    <div class="container mt-5p-5 text-dark">
        @foreach ($appointments as $appointment)
            <div class="card rounded my-5 shadow">
                <div class="card-header">
                    Appointment number #{{$appointment->pivot->id}}
                </div>

                <div class="card-body">
                    <h5 class="card-title">Campaign at: {{$appointment->city}} </h5>
                    <p class="card-text">Location: {{ $appointment->address }}</p>
                    <p class="card-text text-muted">Date: {{ $appointment->pivot->date }}</p>
                    <a href="/appointments/{{ $appointment->pivot->id }}/cancel" class="btn btn-outline-danger">Cancel</a>
                </div>
            </div>
        @endforeach

        @if (count($appointments) == 0)
            <div class="text-center shadow container bg-white mt-5 rounded p-5 text-dark">
                <h4> You have no appointments right now. </h4>
                <a href="/reserve" class="btn btn-success mt-2">Reserve an appointment</a>
            </div>
        @else
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