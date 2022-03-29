<x-app-layout>
    <link href="{{asset('css/reservation.css')}}" rel="stylesheet">

    <div class="mt-5 text-center">
        @if (session('message'))
            <div class="container alert alert-dark" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <div class="text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <h4 class="mb-3 text-center"> Update Hospital (#{{$hospital->id}}) </h4>    
            <form method="POST">
                @csrf
                <div class="form-group row">
                    <div class="col-12 col-md-6">
                        <label>Name</label>
                        <input value="{{$hospital->name}}" type="text" class="form-control" name="name" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label>Is Isolation</label>
                        <br>
                        <input value="{{$hospital->is_isolation}}" class="form-check-input" type="checkbox" name="is_isolation" checked>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12 col-md-6">
                        <label>Capacity</label>
                        <input value="{{$hospital->capacity}}" class="form-control" type="number" min="1" name="capacity" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label>City</label>
                        <select name="city" class="form-control">
                            @foreach ($cities as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="container text-center my-3">
                    <button type="submit" style="width: 300px;" class="btn btn-success">Update</button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
