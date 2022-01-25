<x-base-layout>
    <div class="mt-6">

        <div class="mx-auto text-center mt-5">
            <form class="inline-block bg-black bg-opacity-50 p-8 text-justify" method="POST" action="{{ route('login') }}">
                @csrf
                <img src="{{ asset('ministryofhealth.png') }}" class="w-13 h-13 mx-auto mb-2">

                <div class="mt-3 grid grid-cols-3 text-white font-bold">
                    <div class="px-20">Question</div>
                    <div class="mx-auto">Yes</div>
                    <div class="mx-auto">No</div>
                </div>

                <div class="mt-8 grid grid-cols-3">
                    <label for="question" value="Question 1" class="px-20 text-white font-medium text-sm">Question 1</label>

                    <input id="question" class="mx-auto" type="radio" name="question" value="Male"/>
                    <input id="question" class="mx-auto" type="radio" name="question" value="Female" />
                </div>
                
                <div class="mt-3 grid grid-cols-3">
                    <label for="question" class="px-20 text-white font-medium text-sm">Question 2</label>

                    <input id="question" class="mx-auto" type="radio" name="question" value="Male"/>
                    <input id="question" class="mx-auto" type="radio" name="question" value="Female" />
                </div>
                
                <div class="mt-3 grid grid-cols-3">
                    <label for="question" class="px-20 text-white font-medium text-sm">Question 3</label>

                    <input id="question" class="mx-auto" type="radio" name="question" value="Male"/>
                    <input id="question" class="mx-auto" type="radio" name="question" value="Female" />
                </div>
                
                <div class="mt-3 grid grid-cols-3">
                    <label for="question" class="px-20 text-white font-medium text-sm">Question 4</label>

                    <input id="question" class="mx-auto" type="radio" name="question" value="Male"/>
                    <input id="question" class="mx-auto" type="radio" name="question" value="Female" />
                </div>
                
                <div class="mt-3 grid grid-cols-3">
                    <label for="question" class="px-20 text-white font-medium text-sm">Question 5</label>

                    <input id="question" class="mx-auto" type="radio" name="question" value="Male"/>
                    <input id="question" class="mx-auto" type="radio" name="question" value="Female" />
                </div>
                
                <div class="mt-3 grid grid-cols-3">
                    <label for="question" class="px-20 text-white font-medium text-sm">Question 6</label>

                    <input id="question" class="mx-auto" type="radio" name="question" value="Male"/>
                    <input id="question" class="mx-auto" type="radio" name="question" value="Female" />
                </div>

                <div class="mt-6">
                    <div class="mt-3 mx-auto text-center">
                        <x-button>
                            Submit
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-base-layout>