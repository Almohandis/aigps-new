<x-app-layout>
    <link href="{{asset('css/reservation.css')}}" rel="stylesheet">

    <div class="mt-5 text-center">
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

        <div class="text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <h4 class="mb-3 text-center"> Update Article # {{$article->id}} </h4>    
            <form method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-6">
                        <label>Title</label>
                        <input value="{{ $article->title }}" type="text" class="form-control" name="title" placeholder="Enter article title" required>
                    </div>
                    
                    <div class="col-12 col-md-6">
                        <label>Article type</label>
                        <br>
                        <select class="form-control" name="type" onchange="changeType(this)" id="type-select">
                            <option value="article" @if($article->type == 'article') selected @endif>Article</option>
                            <option value="image"   @if($article->type == 'image') selected @endif>Image</option>
                            <option value="video"   @if($article->type == 'video') selected @endif>Video</option>
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
                        <textarea class="form-control" rows="5" name="content" placeholder="Enter article content" required>{{ $article->content }}</textarea>
                    </div>

                    <div class="col-12 col-md-6">
                        <div id="image-div" class="d-none">
                            <label>Add image</label>
                            <br>
                            <input id="image-input" class="form-control" type="file" name="path" disabled>
                        </div>
                        <div id="video-div" class="d-none">
                            <label>Add Video Url</label>
                            <br>
                            <input id="video-input" class="form-control" placeholder="Enter video url" type="text" name="path" disabled>
                        </div>
                    </div>
                </div>

                <script>
                    changeType(document.getElementById('type-select'));
                </script>

                <div class="container text-center my-3">
                    <button type="submit" style="width: 300px;" class="btn btn-success">Add</button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
