<x-app-layout>
    <div class="mt-5 text-center">
        <h1 class="aigps-title">Gallery</h1>

        <div class="shadow container bg-white mt-5 rounded p-3 text-dark">
            <h3 class="text-center mb-4">List of articles</h3>

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
                                <div class="form-group row justify-content-center mt-2 mb-4">
                                    <div class="row justify-content-center mt-2">
                                        <button style="width: 250px" type="submit" class="mx-2 btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container my-3">
                <a href="?type=article" class="btn btn-primary @if($type == 'article')disabled @endif">Articles</a>
                <a href="?type=image" class="btn btn-primary @if($type == 'image')disabled @endif">Images</a>
                <a href="?type=video" class="btn btn-primary @if($type == 'video')disabled @endif">Videos</a>
            </div>

            <div class="row justify-content-center py-3 px-2">
                @foreach($articles as $index => $article)
                    @if($article->type == 'image')
                      <!-- Modal -->
                        <div class="modal fade" style="margin-top: 80px;" id="exampleModal{{$index}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ $article->title }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="max-height: 70vh;">
                                        <img src="{{ asset('storage/'.$article->path) }}" class="img-fluid rounded-start">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <img data-bs-toggle="modal" data-bs-target="#exampleModal{{$index}}" style="width: 250px; cursor: pointer; max-height: 300px;"  src="{{ asset('storage/'.$article->path) }}" class="img-fluid rounded-start m-3">

                    
                    @elseif($article->type == 'video')
                        <iframe style="width: 450px; cursor: pointer;" width="100%" src="{{ Str::replace('watch?v=', 'embed/', $article->path) }}">
                        </iframe>
                    
                        <div class="card my-2 text-start col-12 col-lg-5 mx-2">
                            <div class="row g-0">
                                <div class="col-md-4 my-2">
                                    <iframe width="100%" src="{{ Str::replace('watch?v=', 'embed/', $article->path) }}">
                                    </iframe>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a class="link-dark text-decoration-none" href="/gallery/{{ $article->id }}">{{ $article->title }}</a>
                                        </h5>
                                        
                                        <small class="card-text text-muted">
                                            {{ Str::limit($article->content, 200) }}
                                            <a class="link-primary text-decoration-none" href="/gallery/{{ $article->id }}">Read more</a>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card col-12 text-start my-2 col-lg-5 mx-2">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a class="link-dark text-decoration-none" href="/gallery/{{ $article->id }}">{{ $article->title }}</a>
                                </h5>

                                <small class="card-text text-muted">
                                    {{ Str::limit($article->content, 200) }}
                                    <a class="link-primary text-decoration-none" href="/gallery/{{ $article->id }}">Read more</a>
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