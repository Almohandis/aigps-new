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
                                        <button style="width: 250px" type="submit" class="mx-2 btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center py-3 px-2">
                @foreach($articles as $article)
                    @if($article->type == 'image')
                        <div class="card my-2 text-start col-12 col-lg-5 mx-2">
                            <div class="row g-0">
                                <div class="col-md-4 my-2">
                                    <a class="link-dark text-decoration-none" href="/gallery/{{ $article->id }}">
                                        <img src="{{ asset('storage/'.$article->path) }}" class="img-fluid rounded-start">
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a class="link-dark text-decoration-none" href="/gallery/{{ $article->id }}">{{ $article->title }}</a>
                                        </h5>
                                        
                                        <small class="card-text text-muted">
                                            {{ Str::limit($article->content, 200) }}
                                            <a class="link-primary" href="/gallery/{{ $article->id }}">Read more</a>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($article->type == 'video')
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