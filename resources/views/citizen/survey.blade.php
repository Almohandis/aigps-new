<x-base-layout>
    <div class="mt-6">
        <img src="{{ asset('survey.jpg') }}" class="fourth-header">
        <div class="divide"></div>
        <div class="wrap"></div>
        <h1 class="ml-5 text-left text-4xl text-white" style="text-shadow: 2px 2px 8px #000000;">
            Complete the survey
        </h1>
        <script src="https://kit.fontawesome.com/a1983178b4.js" crossorigin="anonymous"></script>
       
        <script>
            function Scrolldown() {
                window.scroll(0,650); 
                }
            window.onload = Scrolldown;
        </script>
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

                <div class="mt-3">
                    <label class="text-white font-medium text-sm" id="Q">Do you have today or in the past ten days Any symptoms such as fever, cough, shortness of breath, muscle aches, headache, <br>sore throat, runny nose, nausea, vomiting or diarrhea?</label>
                    <div class="radio">
                        <input class="ml-5" type="radio" name="question1" value="Yes"/>
                        <label class="text-gray-400 text-sm mr-5" id="Q">Yes</label>
                        <input type="radio" name="question1" value="No" />
                        <label class="text-gray-400 text-sm" id="Q">No</label>
                    </div>
                </div>
                <br>
                
                <div class="mt-3">
                    <label class="text-white font-medium text-sm" id="Q">have you been infected with the Covid-19 during the past 3 months, or were you suspected of having it?</label>
                    <div class="radio">
                        <input class="ml-5" type="radio" name="question2" value="Yes"/>
                        <label class="text-gray-400 text-sm mr-5" id="Q">Yes</label>
                        <input type="radio" name="question2" value="No" />
                        <label class="text-gray-400 text-sm" id="Q">No</label>
                    </div>
                </div>
                <br>
                
                <div class="mt-3">
                    <label class="text-white font-medium text-sm" id="Q">Have you received any vaccinations within 14 days (eg seasonal flu vaccination)?</label>
                    <div class="radio">
                        <input class="ml-5" type="radio" name="question3" value="Yes"/>
                        <label class="text-gray-400 text-sm mr-5" id="Q">Yes</label>
                        <input type="radio" name="question3" value="No" />
                        <label class="text-gray-400 text-sm" id="Q">No</label>
                    </div>
                </div>

                <br>
                <div class="mt-3">
                    <label class="text-white font-medium text-sm" id="Q">Have you ever had an allergy to a medicine or vaccine?</label>

                    <div class="radio">
                        <input class="ml-5" type="radio" name="question4" value="Yes"/>
                        <label class="text-gray-400 text-sm mr-5" id="Q">Yes</label>
                        <input type="radio" name="question4" value="No" />
                        <label class="text-gray-400 text-sm" id="Q">No</label>
                    </div>
                </div>
                <br>
                <div class="mt-3">
                    <label class="text-white font-medium text-sm" id="Q">Do you suffer from diseases that weaken the immune system (such as cancerous tumors)?</label>

                    <div class="radio">
                        <input class="ml-5" type="radio" name="question5" value="Yes"/>
                        <label class="text-gray-400 text-sm mr-5" id="Q">Yes</label>
                        <input type="radio" name="question5" value="No" />
                        <label class="text-gray-400 text-sm" id="Q">No</label>
                    </div>
                </div>
                <br>
                <div class="mt-3">
                    <label class="text-white font-medium text-sm" id="Q">Do you use immunosuppressant drugs such as cortisone?</label>

                    <div class="radio">
                        <input class="ml-5" type="radio" name="question6" value="Yes"/>
                        <label class="text-gray-400 text-sm mr-5" id="Q">Yes</label>
                        <input type="radio" name="question6" value="No" />
                        <label class="text-gray-400 text-sm" id="Q">No</label>
                    </div>
                </div>
                <br>
                <div class="mt-3">
                    <label class="text-white font-medium text-sm" id="Q">Do you suffer from immune diseases (eg AIDS)?</label>

                    <div class="radio">
                        <input class="ml-5" type="radio" name="question7" value="Yes"/>
                        <label class="text-gray-400 text-sm mr-5" id="Q">Yes</label>
                        <input type="radio" name="question7" value="No" />
                        <label class="text-gray-400 text-sm" id="Q">No</label>
                    </div>
                </div>
                <br>
                <div class="mt-3">
                    <label class="text-white font-medium text-sm" id="Q">Do you suffer from high blood pressure (unstable)?</label>

                    <div class="radio">
                        <input class="ml-5" type="radio" name="question8" value="Yes"/>
                        <label class="text-gray-400 text-sm mr-5" id="Q">Yes</label>
                        <input type="radio" name="question8" value="No" />
                        <label class="text-gray-400 text-sm" id="Q">No</label>
                    </div>
                </div>
                <br>
                <div class="mt-3">
                    <label class="text-white font-medium text-sm" id="Q">Do you suffer from diabetes (unstable)?</label>

                    <div class="radio">
                        <input class="ml-5" type="radio" name="question9" value="Yes"/>
                        <label class="text-gray-400 text-sm mr-5" id="Q">Yes</label>
                        <input type="radio" name="question9" value="No" />
                        <label class="text-gray-400 text-sm" id="Q">No</label>
                    </div>
                </div>
                <br>
                <div class="mt-3">
                    <label class="text-white font-medium text-sm" id="Q">Do you suffer from chronic heart disease?</label>

                    <div class="radio">
                        <input class="ml-5" type="radio" name="question10" value="Yes"/>
                        <label class="text-gray-400 text-sm mr-5" id="Q">Yes</label>
                        <input type="radio" name="question10" value="No" />
                        <label class="text-gray-400 text-sm" id="Q">No</label>
                    </div>
                </div>
                <br>
                <div class="mt-3">
                    <label class="text-white font-medium text-sm" id="Q">Do you suffer from chronic nervous diseases or nervous spasms?</label>

                    <div class="radio">
                        <input class="ml-5" type="radio" name="question11" value="Yes"/>
                        <label class="text-gray-400 text-sm mr-5" id="Q">Yes</label>
                        <input type="radio" name="question11" value="No" />
                        <label class="text-gray-400 text-sm" id="Q">No</label>
                    </div>
                </div>
                <br>
                <div class="mt-3">
                    <label class="text-white font-medium text-sm" id="Q">Do you suffer from blood diseases (eg Haemophilia or blood clots)?</label>

                    <div class="radio">
                        <input class="ml-5" type="radio" name="question12" value="Yes"/>
                        <label class="text-gray-400 text-sm mr-5" id="Q">Yes</label>
                        <input type="radio" name="question12" value="No" />
                        <label class="text-gray-400 text-sm" id="Q">No</label>
                    </div>
                </div>
                <br>
                <div class="mt-3">
                    <label class="text-white font-medium text-sm" id="Q">(For women) Are you currently pregnant or planning to become pregnant in the near future (within a year)?</label>

                    <div class="radio">
                        <input class="ml-5" type="radio" name="question13" value="Yes"/>
                        <label class="text-gray-400 text-sm mr-5" id="Q">Yes</label>
                        <input type="radio" name="question13" value="No" />
                        <label class="text-gray-400 text-sm" id="Q">No</label>
                    </div>
                </div>
                <br>
                <div class="mt-3">
                    <label class="text-white font-medium text-sm" id="Q">(For women) Are you breastfeeding a baby under 6 months?</label>

                    <div class="radio">
                        <input class="ml-5" type="radio" name="question14" value="Yes"/>
                        <label class="text-gray-400 text-sm mr-5" id="Q">Yes</label>
                        <input type="radio" name="question14" value="No" />
                        <label class="text-gray-400 text-sm" id="Q">No</label>
                    </div>
                </div>
                <br>
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