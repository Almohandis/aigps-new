<x-base-layout>
    <div class="mt-6">
        <h1 class="ml-5 text-left text-4xl text-white" style="text-shadow: 2px 2px 8px #000000;">
            My profile
        </h1>

        @if (session('message'))
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
        @endif

        <div class="mx-auto text-center mt-5">

            <div class="inline-block bg-black bg-opacity-50 p-8 text-justify">
                If you have a passport and want to request your <strong>medical passport</strong>, type in your
                passport number and click on the button below
                <form action="/medical-passport" method="POST">
                    @csrf
                    <input type="text" name="passport_number">
                    <input type="submit" value="Request medical passport">
                </form>
            </div>
        </div>
</x-base-layout>
