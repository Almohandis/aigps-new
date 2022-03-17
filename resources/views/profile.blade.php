<x-base-layout>
    <div class="mt-6">

        @if (session('message'))
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
        @endif

        <div class="mx-auto text-center mt-5">

            <div class="inline-block bg-black bg-opacity-50 p-8 text-justify" style="background-color: white;box-shadow: black;box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.1);">
                If you have a passport and want to request your <strong>medical passport</strong>, type in your
                passport number and click on the button below
                <form action="/medical-passport" method="POST">
                    @csrf
                    <input type="text" name="passport_number" style="margin-left: 15rem;margin-top: 2rem;">
                    <input type="submit" value="Request medical passport" class="req-btn">
                </form>
            </div>
        </div>
</x-base-layout>
