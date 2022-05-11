<x-app-layout>
    <div class="mt-5 text-center">
        <h1 class="aigps-title">Manage Doctors</h1>

        @if (session('success'))
            <div class="container alert alert-success" role="alert">
                {{ session('success') }}
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

        <div class="text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>National ID</th>
                        <th>Hospital</th>
                        <th>Campaign</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->national_id }}</td>
                        <td>{{ $hospital }}</td>
                        <td>{{ $campaign }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
