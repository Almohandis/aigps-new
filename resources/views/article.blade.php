<x-app-layout>
    <div class="mt-6">
        <h1 class="ml-5 text-left text-4xl text-white text-center" style="text-shadow: 2px 2px 8px #000000;">
            {{ $article->title }}
        </h1>

        @if($article->type == 'video')
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="{{ $article->link }}" allowfullscreen></iframe>
            </div>
        @elseif($article->path)
            <img class="w-full" src="{{ Storage::disk('public')->url($article->path) }}" alt="">
        @endif

        <div class="mx-auto text-center mt-5 text-white">
            {{ $article->content }}
        </div>
    </div>
</x-app-layout>