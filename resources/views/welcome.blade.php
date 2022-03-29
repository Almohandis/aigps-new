<x-app-layout>
    <link href="{{asset('css/welcome.css')}}" rel="stylesheet">
    <video class="aigps-video" loop autoplay muted>
        <source src="Vaccine Dusk.mp4" type="video/mp4">
    </video>

    <div class="container aigps-welcome-content">
        <h1 class="project-name" style="text-shadow: 2px 2px 8px #000000;">AIGPS</h1>
        <p class="type">
            The new AI system
            <br>
            that is used as a tool
            <br>
            to support the fight
            <br>
            against any
            <br>
            viral pandemic.
        </p>

        <div class="reserve_button">
            <a href="/reserve"
                class="mx-auto mt-8 text-center bg-blue-500 text-white text-lg font-semibold px-4 py-2 rounded-lg shadow-lg hover:bg-blue-400">
                Reserve Vaccination
            </a>
        </div>
        <div class="article_button">
            <a class="mx-auto mt-8 text-center bg-blue-500 text-white text-lg font-semibold px-4 py-2 rounded-lg shadow-lg hover:bg-blue-400"
                id="article_button" onclick="viewArticles()">
                View gallery >>
            </a>
        </div>


        <div id="slideshow-container" class="slideshow-container">
            @if (isset($articles))
                @foreach ($articles as $article)
                    <div class="slideshow-container__slides">
                        <div class="slideshow-container__text">
                            <h1 class="article-head"><b>{{ $article->title }}</b></h1>
                            @if (isset($article->path) && $article->path != null)
                                <img class="awareness-img" id="myImg" src="{{ asset('article_images/' . $article->path) }}">
                                
                            @endif
                            @if (isset($article->video_link) && $article->video_link != null)
                                <iframe class="video"
                                    src="{{ $article->video_link }}?autoplay=1&mute=1"></iframe>
                            @endif
                            <div class="article">
                                <p class="article-body">{{ $article->content }}<br>
                                    @if (isset($article->full_article_link))
                                        <a style="color:red;">To read the full article</a>
                                        <a style="color:#6868cc;text-decoration: underline;"
                                            href="{{ $article->full_article_link }}">click here</a>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            <a class="slideshow-container__prev" onclick="plusSlides(-1,'slide-right')">&#10094;</a>
            <a class="slideshow-container__next" onclick="plusSlides(1,'slide-left')">&#10095;</a>
            <div id="myModal" class="modal">
                <img class="modal-content" id="img-modal-source">
            </div>
        </div>
    </div>
    <footer id="footer">
        <img src="{{ asset('mti.png') }}" class="footer-logo">
        © 2022 MTI University. All Rights Reserved
    </footer>

</x-app-layout>
