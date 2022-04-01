<x-app-layout>
    <div class="mt-5 text-center">
        <h1 class="aigps-title">Gallery</h1>

        <div class="shadow container bg-white mt-5 rounded p-3 text-dark">
            <h3 class="text-center mb-4">List of articles</h3>

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