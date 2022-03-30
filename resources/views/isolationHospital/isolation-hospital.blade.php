<x-app-layout>
    <link href="{{asset('css/reservation.css')}}" rel="stylesheet">

    <div class="mt-5 text-center">
        <h1 class="aigps-title">Update Hospital Statistics</h1>

        @if (session('success'))
            <div class="container alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div>
                <div class="alert alert-danger" role="alert">
                    <p>Something went wrong.</p>

                    <ul class="">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if($hospital)
            <div class="text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
                <h4 class="mb-3 text-center"> Update statistics for hospital [{{ $hospital->name }}] </h4>    
                <form action="/staff/isohospital/update" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-12 col-md-6">
                            <label>Capacity</label>
                            <input type="text" class="form-control" name="capacity" value="{{$hospital->capacity}}" required>
                        </div>

                        <div class="col-12 col-md-6">
                            <label>Recoveries</label>
                            <input type="text" class="form-control" name="recoveries" value="0" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12 col-md-6">
                            <label>Deaths</label>
                            <input type="text" class="form-control" name="deaths" value="0" required>
                        </div>
                    </div>

                    <div class="container text-center my-3">
                        <button type="submit" style="width: 300px;" class="btn btn-success">Update</button>
                    </div>
                </form>

            </div>
        @endif
    </div>
</x-app-layout>
