<x-app-layout>
    <div class="mt-6">
        <img src="{{ asset('appointments.jpg') }}" class="second-header">
        <div class="divide"></div>
        <div class="wrap"></div>
        <h1 class="ml-5 text-left text-4xl text-white" style="text-shadow: 2px 2px 8px #000000;">
            My Appointments
        </h1>
        <script>
            function Scrolldown() {
                        window.scroll(0,580); 
                        
                    
                    }
                    window.onload = Scrolldown;
        </script>

        <!-- List appointments -->
        <div class="ml-5 mt-6">
            <div class="flex flex-wrap" id="appointment_list">
                @foreach ($appointments as $appointment)
                    <div class="bg-white shadow-md rounded-lg p-4" id="appointments">
                        <div class="flex flex-wrap mb-5">
                            <div class="">
                                <h3 class="text-center text-2xl text-gray-800" id="appoint">
                                    Campaign: {{ $appointment->city }}
                                </h3>
                            </div>
                        </div>
                        <div class="flex flex-wrap">
                            <div class="">
                                <h3 class="text-center text-lg text-gray-800" id="appoint">
                                    Appointment at: {{ $appointment->pivot->date }}
                                </h3>
                            </div>
                        </div>
                        <div class="flex flex-wrap">
                            <div class="">
                                <h3 class="text-center text-lg text-gray-800" id="appoint">
                                    Location: {{ $appointment->address }}
                                </h3>
                            </div>
                        </div>
                        <div class="flex flex-wrap">
                            <div class="cancel-appointment">
                                <a href="/appointments/{{ $appointment->pivot->id }}/cancel" class="text-red-500" id="cancel">
                                    Cancel
                                </a>
                            </div>
                    </div>
                    <hr />
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>