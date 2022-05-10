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

            <div class="accordion mb-4" id="campaignsAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne">
                            Filters & search
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                        data-bs-parent="#campaignsAccordion">
                        <div class="accordion-body">
                            <form method="GET" class="row">
                                <div class="form-group mb-2">
                                    <label class="">Search</label>
                                    <input type="text" name="search" class="form-control" placeholder="Search by title" value="{{ request()->search }}">
                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-3">
                                    <label for="sort" class="">Sort by</label>
                                    <div>
                                        <select class="form-control" name="sort">
                                            <option value="">Select Sorting</option>
                                            <option value="title">Title</option>
                                            <option value="type">Type</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-3">
                                    <label class="">Sort Order</label>
                                    <div class="">
                                        <select class="form-control" name="order">
                                            <option value="asc">Ascending</option>
                                            <option value="desc">Descending</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row justify-content-center mt-2 mb-4">
                                    <div class="row justify-content-center mt-2">
                                        <button style="width: 250px" type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Type</th>
                        <th scope="col">Update</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                        <tr>
                            <td>{{ $article->title }}</td>
                            <td>{{ $article->type }}</td>
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

            <div>
                {{ $articles->links() }}
            </div>
        </div>

        <div class="text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <h4 class="mb-3 text-center"> Add a new Article </h4>
            <form action="/staff/moh/articles/add" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-6">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" placeholder="Enter article title">
                    </div>
                    
                    <div class="col-12 col-md-6">
                        <label>Article type</label>
                        <br>
                        <select class="form-control" name="type" onchange="changeType(this)">
                            <option value="article">Article</option>
                            <option value="image">Image</option>
                            <option value="video">Video</option>
                        </select>
                    </div>

                    <script>
                        function changeType(input) {
                            if (input.value == 'image') {
                                show('image')
                                hide('video')
                            } else if (input.value == 'video') {
                                hide('image')
                                show('video')
                            } else {
                                hide('image')
                                hide('video')
                            }
                        }

                        function show(name) {
                            document.getElementById(name + '-div').classList.remove('d-none');
                            document.getElementById(name + '-div').classList.add('d-block');

                            document.getElementById(name + '-input').disabled = false;
                        }

                        function hide(name) {
                            document.getElementById(name + '-div').classList.remove('d-block');
                            document.getElementById(name + '-div').classList.add('d-none');

                            document.getElementById(name + '-input').disabled = true;
                        }
                    </script>
                </div>

                <div class="row mt-2">
                    <div class="col-12 col-md-6">
                        <label>Content</label>
                        <textarea class="form-control" rows="5" name="content" placeholder="Enter article content"></textarea>
                    </div>

                    <div class="col-12 col-md-6">
                        <div id="image-div" class="d-none">
                            <label>Add image</label>
                            <br>
                            <input id="image-input" class="form-control" type="file" name="path" required disabled>
                        </div>
                        <div id="video-div" class="d-none">
                            <label>Add Video Url</label>
                            <br>
                            <input id="video-input" class="form-control" placeholder="Enter video url" type="text" name="path" required disabled>
                        </div>
                    </div>
                </div>

                <div class="container text-center my-3">
                    <button type="submit" style="width: 300px;" class="btn btn-success">Add</button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
