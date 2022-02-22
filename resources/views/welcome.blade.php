<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="pt-8 sm:pt-0">
            <h1 class="text-center text-9xl text-white" style="text-shadow: 2px 2px 8px #000000;">AIGPS</h1>
            <p class="text-center text-white">
                The new AI system 
                that is used as a tool
                to support the fight 
                against any
                viral pandemic. 
            </p>

            <div class="text-center mt-9">
                <a href="/reserve" class="mx-auto mt-8 text-center bg-blue-500 text-white text-lg font-semibold px-4 py-2 rounded-lg shadow-lg hover:bg-blue-400">
                    Reserve Vaccination
                </a>
            </div>

        </div>

        <h1 class="ml-5 text-left text-4xl text-white text-center" style="text-shadow: 2px 2px 8px #000000;">
            List of articles
        </h1>

        @foreach($articles as $article)
            <div class="mx-auto text-center mt-5 text-white">
                @if($article->type == 'image')
                    <img src="{{ $article->link }}" alt="">
                @endif
                <a href="/articles/{{ $article->id }}">
                    {{ $article->title }}
                </a>
            </div>
        @endforeach
    </div>
</x-app-layout>