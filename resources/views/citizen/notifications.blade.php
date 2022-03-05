<x-base-layout>
    <div class="mt-6">
        <img src="{{ asset('not.jpg') }}" class="third-header">
        <div class="divide"></div>
        <div class="wrap"></div>
        <h1 class="ml-5 text-left text-4xl text-white" style="text-shadow: 2px 2px 8px #000000;">
            Notifications
        </h1>

        <div class="mx-auto text-center mt-5">
            
            <div class="inline-block bg-black bg-opacity-50 p-8 text-justify">
                @foreach($notifications as $notification)
                    <div class="text-white border-1 border-white">
                        {{ $notification->text }}
                    </div>
                @endforeach
            </form>
        </div>
    </div>
</x-base-layout>