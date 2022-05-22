<x-app-layout>
    <div class="mt-5">
        <div class="shadow container bg-white mt-5 rounded p-3 text-dark text-center">
            <h5 class="text-center col"> {{ $article->title }} </h5>

            <div>
                @if($article->author)
                    <small class="text-muted">Author: {{ $article->author }}</small>
                @endif
            </div>

            <small class="text-muted">Published: {{ $article->created_at->diffForHumans() }}</small>

            <div class="my-3 row justify-content-center">
                <hr class="col-8">
            </div>

            @if($article->type == 'image')
                <img src="{{ asset('storage/'.$article->path) }}" class="img-fluid rounded">
            @elseif($article->type == 'video')
                <iframe class="col-11 col-md-8 col-lg-5" height="300" src="{{ Str::replace('watch?v=', 'embed/', $article->path) }}"></iframe>
            @endif

            <p class="px-4 mt-2" style="text-align: justify;">
                {{ $article->content }}  
            </p>
        </div>
    </div>
</x-app-layout>