<x-app-layout>
    <link href="{{asset('css/reservation.css')}}" rel="stylesheet">

    <div class="mt-5 text-center">
        <h1 class="aigps-title">Manage Survey Questions</h1>

        @if (session('message'))
            <div class="container alert alert-dark" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <x-help-modal></x-help-modal>
        @if ($errors->any())
            <div class="container">
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

        <div class="table-responsive text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <h4 class="text-center mb-3"> All Questions </h4>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Update</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $question)
                        <tr>
                            <form method="POST" action="/staff/moh/survey/{{$question->id}}/update">
                                @csrf
                                <td>
                                    <input type="text" class="form-control" name="title" value="{{ $question->title }}">
                                </td>
                                <td>
                                    <button class="btn btn-outline-primary"> Update </button>
                                </td>
                            </form>
                            <form method="POST" action="/staff/moh/survey/{{$question->id}}/delete">
                                @csrf
                                <td>
                                    <button class="btn btn-outline-danger"> Delete </button>
                                </td>
                            </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex">
                <ul class="pagination justify-content-center">
                    @if ($questions->previousPageUrl())
                        <li class="page-item"><a class="page-link" href="/staff/moh/survey/?page={{ $questions->currentPage() - 1 }}">Previous</a></li>
                    @endif
                    
                    
                    @for($page = 1; $page <= $questions->lastPage(); $page++)
                        <li class="page-item"><a class="page-link" href="/staff/moh/survey/?page={{ $page }}">{{ $page }}</a></li>
                    @endfor

                    @if ($questions->nextPageUrl())
                        <li class="page-item"><a class="page-link" href="/staff/moh/survey/?page={{ $questions->currentPage() + 1 }}">Next</a></li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <h4 class="mb-3 text-center"> Add a new Question </h4>    
            <form action="/staff/moh/survey/add" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" placeholder="Enter the question" required>
                    </div>
                </div>
                <div class="container text-center my-3">
                    <button type="submit" style="width: 300px;" class="btn btn-success">Add</button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
