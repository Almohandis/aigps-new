<x-base-layout>
    <div class="mt-6">
        <img src="{{ asset('survey.jpg') }}" class="fourth-header">
        <div class="divide"></div>
        <div class="wrap"></div>
        <h1 class="ml-5 text-left text-4xl text-white" style="text-shadow: 2px 2px 8px #000000;">
            Complete the survey
        </h1>
        <script src="https://kit.fontawesome.com/a1983178b4.js" crossorigin="anonymous"></script>
       

        <div class="mx-auto text-center mt-5">
            
            <form class="inline-block bg-black bg-opacity-50 p-8 text-justify" method="POST" action="/survey">
            <img src="{{ asset('mioh-logo.png') }}" class="mioh-logo">
                @if ($errors->any())
                    <div>
                        <div class="errors">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <a class="error">{{ __('Please Answer All The Survey Questions') }}</a>
                        </div>

                        <ul class="mt-3 list-disc list-inside text-sm text-red-600" style="text-align:center;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @csrf

                @foreach($questions as $question)
                    <div class="mt-3">
                        <label class="text-white font-medium text-sm" id="Q"> {{ $question->title }} </label>
                        <div class="radio">
                            <input class="ml-5" type="radio" name="answers[{{ $question->id }}]" value="Yes"/>
                            <label class="text-gray-400 text-sm mr-5" id="Q">Yes</label>
                            <input type="radio" name="answers[{{ $question->id }}]" value="No" />
                            <label class="text-gray-400 text-sm" id="Q">No</label>
                        </div>
                    </div>
                    <br>
                @endforeach
                <div class="mt-6">
                    <div class="mt-3 mx-auto text-right">
                        <x-button>
                            Submit
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-base-layout>