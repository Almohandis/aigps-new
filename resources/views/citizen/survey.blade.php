<x-app-layout>
    <link href="{{asset('css/reservation.css')}}" rel="stylesheet">


    <div class="mt-5 text-center">
        <h1 class="aigps-title">Survey</h1>

        <div class="text-start shadow container bg-white mt-5 rounded p-5 text-dark">
             <!-- Modal and button -->
             <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#exampleModal"
             style="float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                 fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                 <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                 <path
                     d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z" />
             </svg> Help</button>

         <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true" style="top: 100px;" data-backdrop="static" data-keyboard="true">
             <div class="modal-dialog">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLabel"><svg xmlns="http://www.w3.org/2000/svg"
                                 width="16" height="16" fill="currentColor" class="bi bi-question-circle"
                                 viewBox="0 0 16 16">
                                 <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                 <path
                                     d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z" />
                             </svg> &nbsp; What is this Page ?</h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal"
                             aria-label="Close"></button>
                     </div>
                     <div class="modal-body" style="height: 300px; overflow:scroll;">
                         <p><b></b></p>
                         • This page shows a couple of simple diagnostic questions.
                         <br>
                         • The goal of this survey is to evaluate if you are eligible to take the vaccine or not .
                         <br>
                         • Make sure you read the questions well, and answer all the questions honestly.
                         <br>
                         • After finishing questions, click submit to finish the survey.
                         <br>
                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     </div>
                 </div>
             </div>
         </div> 
            <div class="text-center">
                <img width="100" class="text-center mb-2" src="{{ asset('mioh-logo.png') }}">
            </div>

            <x-help-modal></x-help-modal>
            @if ($errors->any())
                <div>
                    <div class="alert alert-danger" role="alert">
                        <p>Something went wrong. Please check the form below for errors.</p>

                        <ul class="">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="/survey" method="POST" id="procceed_form" class="text-center">
                @csrf

                @foreach ($questions as $question)
                    <div class="mt-3 row text-start">
                        <label class="text-black col-12 col-md-9"> {{ $question->title }} </label>
                        <div class="d-flex radio col-12 col-md-3 justify-content-center">
                            <input class="form-check-input me-2" type="radio" name="answers[{{ $question->id }}]" value="Yes">
                            <label class="me-3">Yes</label>
                            <input class="form-check-input me-2" type="radio" name="answers[{{ $question->id }}]" value="No">
                            <label class="text-gray-400 text-sm">No</label>
                        </div>
                    </div>
                    <br>
                @endforeach

                <button class="btn btn-success mt-5" type="submit" id="procceed_button" style="width: 200px;">
                    Submit
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
