<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
        <div class="pt-8 sm:pt-0">
            <h1>Choose a hospital to update its statistics</h1>
            <form action="/staff/isohospital/update" method='POST'>
                <select name="hospital">
                    <option value="" selected hidden disabled>Choose a hospital</option>
                    @foreach ($hospitals as $hospital)
                        <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                    @endforeach
                </select>
                <h1>Update statistics</h1>

                @csrf
                Total capacity: <input type="number" min="0" name="total_capacity" placeholder="Total capacity">
                <br>
                Intensive care capacity: <input type="number" min="0" name="care_beds" placeholder="Intensive care capacity">
                <br>
                Available intensive care beds: <input type="number" min="0" name="avail_care_beds" placeholder="Available intensive care beds">
                <br>
                Available regular beds: <input type="number" min="0" name="available_beds" placeholder="Available beds">
                <br>
                Recoveries: <input type="number" min="0" name="recoveries" placeholder="Number of recoveries">
                <br>
                Deaths: <input type="number" min="0" name="deaths" placeholder="Number of deaths">
                <br>
                <input type="submit" value="Update">
            </form>
        </div>
    </div>
</x-app-layout>
