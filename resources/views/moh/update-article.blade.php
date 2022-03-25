<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>

        @if ($errors->any())
            <div>
                <div class="font-medium text-red-600">
                    {{ __('Whoops! Something went wrong.') }}
                </div>

                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="pt-8 sm:pt-0">
            <form action="/staff/moh/articles/{{$article->id}}/update" enctype="multipart/form-data" method="POST" class="add-article-form">
                <h1 class="add-hero2">Update Article</h1>
                @csrf
                <div style="margin-left: 18rem;margin-top: 1rem;">
                    <label for="title">Article title</label>
                    <input style="width: 25rem;" type="text" name="title" id="title" placeholder="Enter article title" value="{{$article->title}}"
                        required>
                </div>
                <br>
                <div style="margin-left: 18rem;">
                    <label for="content">Article content</label>
                    <br>
                    <textarea style="margin-left: 7rem;margin-top: -2rem;" name="content" id="content" cols="30" rows="10"
                        placeholder="Enter article content" required>{{$article->content}}</textarea>
                </div>
                <br>
                <div style="margin-left: 18rem;">
                    <label for="image">Add image</label>
                    <input type="file" name="image" id="image" style="margin-left: 1.5rem;">
                </div>
                <br>
                <div style="margin-left: 18rem;">
                    <label for="full-link">(Optional) Link to the full article</label>
                    <input type="text" name="full_link" id="full-link" placeholder="Enter full article link"  value="{{$article->full_article_link}}">
                </div>
                <br>
                <div style="margin-left: 18rem;">
                    <label for="video">(Optional) Link to video</label>
                    <input type="text" name="link" id="video" placeholder="Enter video link" value="{{$article->video_link}}">
                </div>
                <br>
                <input type="submit" value="Update" class="submit" style="margin-top: -2rem;">
                <br>
            </form>

        </div>
    </div>
</x-app-layout>