<x-app-layout>
    <link href="{{asset('css/reservation.css')}}" rel="stylesheet">

    <div class="mt-5 text-center">
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

        <div class="text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <!-- Modal and button -->
            <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#exampleModal1"
            style="float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path
                    d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z" />
            </svg> Help</button>

        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                            </svg> &nbsp; How to add a new article, image or video in gallery ?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="height: 300px; overflow:scroll;">
                        <p><b>You can do the following steps:</b></p>
                        <b> • </b> You can edit article:
                        <br>
                        <b>1.</b> If you want, you can change the "article type".
                        <br>
                        <b>2.</b> If you want, Change the "Title" of the article.
                        <br>
                        <b>3.</b> If you want, Change the "content" of the article.
                        <br>
                        <b>4.</b> If you want, Edit the article "authors" name.
                        <br>
                        <b>5.</b> Click "Update" button, to proceed editing article.
                        <br>
                        <br>
                        <b> • </b> You can edit Image:
                        <br>
                        <b>1.</b> If you want, You can change the "article type".
                        <br>
                        <b>2.</b> If you want, Insert the new "Title" of the image (optional).
                        <br>
                        <b>3.</b> If you want, Edit the content (optional).
                        <br>
                        <b>4.</b> Click on "Choose File" to add the image from your computer.
                        <br>
                        <b>5.</b> The browser will open windows explorer, browse the location of the image.
                        <br>
                        <b>6.</b> Select the image,click "open" to open the image.
                        <br>
                        <b>7.</b> Click "Update" button, to proceed editing image.
                        <br>
                        <br>
                        <b> • </b> You can edit Video:
                        <br>
                        <b>1.</b> If you want, You can change the "article type".
                        <br>
                        <b>2.</b> If you want, Insert the new "Title" of the video (optional).
                        <br>
                        <b>3.</b> If you want, Edit the content (optional).
                        <br>
                        <b>4.</b> Copy the youtube link of the video.
                        <br>
                        <b>5.</b> Insert the copied link.
                        <br>
                        <b>6.</b> Click "Update" button, to proceed editing Video.
                        <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
            <h4 class="mb-3 text-center"> Update Article # {{$article->id}} </h4>    
            <form method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-6">
                        <label>Title</label>
                        <input value="{{ $article->title }}" type="text" class="form-control" name="title" placeholder="Enter article title">
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
                                hide('author')
                            } else if (input.value == 'video') {
                                hide('image')
                                show('video')
                                hide('author')
                            } else {
                                hide('image')
                                hide('video')
                                show('author')
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
                        <div id="author-div" class="d-block">
                            <label>Author</label>
                            <br>
                            <input id="author-input" class="form-control" type="text" name="author" required>
                        </div>
                    </div>
                </div>

                <script>
                    changeType(document.getElementById('type-select'));
                </script>

                <div class="container text-center my-3">
                    <button type="submit" style="width: 300px;" class="btn btn-success">Update</button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
