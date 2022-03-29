<x-app-layout>
    <link href="{{asset('css/welcome.css')}}" rel="stylesheet">
    <video class="aigps-video" loop autoplay muted>
        <source src="Vaccine Dusk.mp4" type="video/mp4">
    </video>

    <div class="container aigps-welcome-content">
        <h1 class="text-white h1">AIGPS</h1>
        <p class="text-light mt-1">
            The new AI system that is used as a tool <br> to support the fight against any viral pandemic.
        </p>

        <div class="flex my-md">
            <a href="/reserve" class="btn btn-success btn-md">
                Reserve Vaccine
            </a>

            <a href="/gallery" class="btn btn-success btn-md ms-2">
                Visit Gallery
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
