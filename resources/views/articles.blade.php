<x-app-layout>
    <div class="mt-5 text-center">
        <h1 class="aigps-title">Gallery</h1>

        <div class="shadow container bg-white mt-5 rounded p-3 text-dark">
            <!-- Modal and button -->
            <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#exampleModal" style="float: right;"><svg
                xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-question-circle" viewBox="0 0 16 16">
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
                            </svg> &nbsp; What is the "Gallery" page ?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="height: 300px; overflow:scroll;">
                        <p><b></b></p>
                        • This page have a variation of articles, images & videos that talks about pandemics.
                        <br>
                        • By clicking "Articles" button you can access the articles about pandemics.
                        <br>
                        • By clicking "Images" button, a variety of infographics are displayed.
                        <br>
                        • By clicking "Videos" button, a variety of videos are displayed.
                        <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
            <h3 class="text-center mb-4">List of articles</h3>
            
            @if ($type == 'article')
                <div class="accordion mb-4" id="campaignsAccordion">

                    <div class="accordion-item">

                        <h2 class="accordion-header" id="flush-headingOne">

                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseOne">
                                Filters & search
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                            aria-labelledby="flush-headingOne" data-bs-parent="#campaignsAccordion">
                            <div class="accordion-body">
                                <form method="GET" class="row">
                                    <div class="container row">
                                        <div class="form-group mb-2 col-6">
                                            <label class="">Search</label>
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Search" value="{{ request()->search }}">
                                        </div>
                                        <div class="form-group mb-2 col-6">
                                            <label class="">Search By</label>
                                            <select name="searchby" class="form-control">
                                                <option value="title">Title</option>
                                                <option value="author">Author</option>
                                                <option value="content">Content</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row justify-content-center mt-2 mb-4">
                                        <div class="row justify-content-center mt-2">
                                            <button style="width: 250px" type="submit"
                                                class="mx-2 btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="container my-3">
                <a href="?type=article"
                    class="btn btn-primary @if ($type == 'article') disabled @endif">Articles</a>
                <a href="?type=image"
                    class="btn btn-primary @if ($type == 'image') disabled @endif">Images</a>
                <a href="?type=video"
                    class="btn btn-primary @if ($type == 'video') disabled @endif">Videos</a>
            </div>

            <div class="row justify-content-center py-3 px-2">
                @foreach ($articles as $index => $article)
                    @if ($article->type == 'image')
                        <!-- Modal -->
                        <div class="modal fade" style="margin-top: 80px;" id="exampleModal{{ $index }}"
                            tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ $article->title }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="max-height: 70vh;">
                                        <img src="{{ asset('storage/' . $article->path) }}"
                                            class="img-fluid rounded-start">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <img data-bs-toggle="modal" data-bs-target="#exampleModal{{ $index }}"
                            style="width: 250px; cursor: pointer; max-height: 300px;"
                            src="{{ asset('storage/' . $article->path) }}" class="img-fluid rounded-start m-3">
                    @elseif($article->type == 'video')
                        <iframe style="width: 400px; height: 300px; cursor: pointer;" class="m-3"
                            src="{{ Str::replace('watch?v=', 'embed/', $article->path) }}">
                        </iframe>
                    @else
                        <div class="card col-12 text-start my-2 col-lg-5 mx-2">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a class="text-decoration-none"
                                        href="/gallery/{{ $article->id }}">{{ $article->title }}</a>
                                </h5>

                                <small class="card-text text-muted">
                                    {{ Str::limit($article->content, 200) }}
                                    <a class="link-primary text-decoration-none"
                                        href="/gallery/{{ $article->id }}">Read more</a>
                                </small>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <div>
                {{ $articles->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
