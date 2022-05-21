<x-app-layout>
    <link href="{{ asset('css/reservation.css') }}" rel="stylesheet">


    <div class="mt-5 text-center">
        <h1 class="aigps-title">
            Isolation Hospital Reservation
        </h1>

        <div class="text-start shadow container bg-white mt-5 rounded p-5 text-dark">
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

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Hospital</th>
                        <th scope="col">City</th>
                        <th scope="col">Available</th>
                        <th scope="col">Reserve</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($hospitals as $index => $hospital)
                        <tr>
                            <td>{{ $hospital->name }}</td>
                            <td>{{ $hospital->city }}</td>
                            <td>{{ $hospital->capacity - count($hospital->patients) }}</td>
                            <td>
                                <button data-bs-toggle="modal" data-bs-target="#reserveModal{{$index}}" class="btn btn-success">Reserve</button>
                            </td>
                        </tr>

                        <div class="modal fade" id="reserveModal{{$index}}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="reserveModal{{$index}}Label">Reserve Isolation Hospital</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="/reserve/hospital/{{$hospital->id}}" method="POST">
                                        <div class="modal-body">
                                            @csrf
                                            <p>Reserve isolation hospital in: <span class="text-muted">{{ $hospital->name }}</span></p>
                                            <p>Check in date: </p>
                                            <input type="date" name="checkin_date" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success">Reserve</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>
