<x-app-layout>
    <link href="{{asset('css/reservation.css')}}" rel="stylesheet">

    <div class="mt-5 text-center">
        <h1 class="aigps-title">Manage Articles</h1>

        @if (session('message'))
            <div class="container alert alert-dark" role="alert">
                {{ session('message') }}
            </div>
        @endif

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
            <h4 class="text-center mb-3"> All Articles </h4>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Update</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                        <tr>
                            <td>{{ $article->title }}</td>
                            <td>
                                <a class="btn btn-outline-primary" href="/staff/moh/articles/{{$article->id}}/update"> Update </a>
                            </td>
                            <td>
                                <a class="btn btn-outline-danger" href="/staff/moh/articles/{{$article->id}}/delete"> Delete </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex">
                <ul class="pagination justify-content-center">
                    @if ($articles->previousPageUrl())
                        <li class="page-item"><a class="page-link" href="/staff/moh/articles/?page={{ $articles->currentPage() - 1 }}">Previous</a></li>
                    @endif
                    
                    
                    @for($page = 1; $page <= $articles->lastPage(); $page++)
                        <li class="page-item"><a class="page-link" href="/staff/moh/articles/?page={{ $page }}">{{ $page }}</a></li>
                    @endfor

                    @if ($articles->nextPageUrl())
                        <li class="page-item"><a class="page-link" href="/staff/moh/articles/?page={{ $articles->currentPage() + 1 }}">Next</a></li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <h4 class="mb-3 text-center"> Add a new Article </h4>    
            <form action="/staff/moh/articles/add" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-6">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" placeholder="Enter article title" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label>Add image</label>
                        <br>
                        <input class="form-control" type="file" name="image" required>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12 col-md-6">
                        <label>Content</label>
                        <textarea class="form-control" rows="5" name="content" placeholder="Enter article content" required></textarea>
                    </div>

                    <div class="col-12 col-md-6">
                        <label>(Optional) Link to the full article</label>
                        <input class="form-control" type="text" name="full_link" placeholder="Enter full article link">
                    
                        <label class="mt-2">(Optional) Link to video</label>
                        <input class="form-control" type="text" name="link" placeholder="Enter full article link">
                    </div>
                </div>

                <div class="container text-center my-3">
                    <button type="submit" style="width: 300px;" class="btn btn-success">Add</button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
