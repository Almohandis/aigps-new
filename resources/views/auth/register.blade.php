<x-app-layout>
        <div class="text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <h4 class="mb-3 text-center"> Register </h4>

            <div class="row">
                <div class="col-12 col-md-6 col-lg-4">
                    <label>National ID *</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <label>Name *</label>
                    <input type="text" class="form-control" name="email" required>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <label>Email *</label>
                    <input type="email" class="form-control" name="name" required>
                </div>
                
                <div class="col-12 col-md-6 col-lg-4">
                    <label>Password *</label>
                    <input type="password" class="form-control" name="name" required>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <label>Confirm Password *</label>
                    <input type="password" class="form-control" name="name" required>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <label>Address *</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <label>Telephone Number *</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <label>Country *</label>
                    <select name="country" class="form-control">
                        @foreach ($countries as $country)
                            <option value="{{ $country }}">{{ $country }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <label>City *</label>
                    <select name="City" class="form-control">
                        @foreach ($cities as $city)
                        <option value="{{ $city }}">{{ $city }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <label>Gender *</label>
                    <select name="gender" class="form-control">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <label>Birthdate *</label>
                    <input type="date" class="form-control" name="birthdate" required>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <label>Work Email *</label>
                <input type="email" class="form-control" name="name" required>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <label>Mobile Number *</label>
                <input type="number" class="form-control" name="name" required>
            </div>
            <div class="flex justify-content-between">
                <button class="bg-danger text-white" style="border-radius: 5px;border:none">
                    Cancel
                </button>
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="/login">
                  Already registered?
                </a>

                <button class="bg-primary text-white" style="border-radius: 5px;border:none">
                    Submit
                </button>
            </div>
            
        </div>
</x-app-layout>