<x-base-layout>
    <div class="mt-6">
        <h1 class="ml-5 text-left text-4xl text-white" style="text-shadow: 2px 2px 8px #000000;">
            Complete the survey
        </h1>
        
        <div class="mx-auto text-center mt-2">
            <p class="inline-block text-center text-xl bg-blue-500 font-bold rounded-full text-white w-8 h-8 pt-1">1</p>
            <div class="inline-block mx-3 bg-black w-10 h-1 mb-1 bg-opacity-50"></div>
            <p class="inline-block text-center text-xl bg-white font-bold rounded-full text-blue-500 w-8 h-8 pt-1">2</p>
        </div>

        <div class="mx-auto text-center mt-5">
            
            <form class="inline-block bg-black bg-opacity-50 p-8 text-justify" method="POST" action="/survey">
                @if ($errors->any())
                    <div>
                        <div class="font-medium text-red-600">
                            {{ __('Whoops! Something went wrong.') }}
                        </div>

                        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @csrf

                @foreach($questions as $question)
                    <div class="mt-3">
                        <label class="text-white font-medium text-sm"> {{ $question->title }} </label>
                        <br>
                        <input class="ml-5" type="radio" name="answers[{{ $question->id }}]" value="Yes"/>
                        <label class="text-gray-400 text-sm mr-5">Yes</label>
                        <input type="radio" name="answers[{{ $question->id }}]" value="No" />
                        <label class="text-gray-400 text-sm">No</label>
                    </div>
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