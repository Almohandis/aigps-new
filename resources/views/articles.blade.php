<x-app-layout>
    <div class="mt-6">
        <h1 class="ml-5 text-left text-4xl text-white text-center" style="text-shadow: 2px 2px 8px #000000;">
            List of articles
        </h1>

        @foreach($articles as $article)
            <div class="mx-auto text-center mt-5 text-white">
                @if($article->path)
                    <img src="{{ $article->path }}" alt="">
                @endif
                <a href="/gallery/{{ $article->id }}">
                    {{ $article->title }}
                </a>
            </div>
        @endforeach

        
    </div>
</x-app-layout>